<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use App\Models\FileEntry;
use App\Models\StorageProvider;
use App\Traits\Files\FileLookup;
use App\Traits\Files\StorageResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Validator;

class UploadController extends Controller
{
    use FileLookup, StorageResponse;

    public function upload(Request $request)
    {
        if (subscription()->is_expired) {
            return $this->error(translate('Your subscription has expired', 'settings'));
        }

        $user = auth()->user();

        $originalFileName = $request->file('file')->getClientOriginalName();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'block_patterns'],
            'visibility' => ['nullable', 'boolean'],
            'password' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000', 'block_patterns'],
            'folder' => ['nullable', 'integer', Rule::exists('file_entries', 'id')->where(function ($query) use ($user) {
                return $query->where('user_id', $user->id)->where('type', FileEntry::TYPE_FOLDER);
            })],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return $this->error($error . ' (' . $originalFileName . ')');
            }
        }

        if (!settings('filesystem')->upload->types->status) {
            $extensions = explode(',', settings('filesystem')->upload->types->extensions);
            if (!in_array($request->file('file')->getClientOriginalExtension(), $extensions)) {
                return $this->error(translate('You cannot upload files of this type', 'file system'));
            }
        }

        try {

            $storageProvider = StorageProvider::default()->active()->first();

            if (!$storageProvider) {
                return $this->error(translate('Unavailable storage provider', 'file system'));
            }

            $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

            if ($receiver->isUploaded() === false) {
                return $this->error(str(translate('Failed to upload ({file_name})', 'file system'))->replace('{file_name}', $originalFileName));
            }

            $save = $receiver->receive();

            if (!$save->isFinished()) {
                return $this->error(str(translate('Failed to upload ({file_name})', 'file system'))->replace('{file_name}', $originalFileName));
            }

            $file = $save->getFile();
            $fileExtension = $file->getClientOriginalExtension();
            $fileMimeType = ($this->mimeType($fileExtension)) ? $this->mimeType($fileExtension) : $file->getMimeType();
            $fileSize = $file->getSize();

            if ($fileSize == 0) {
                return $this->error(translate('Empty files cannot be uploaded', 'file system'));
            }

            $maxFileSize = subscription()->upload->max_file_size;
            if ($maxFileSize) {
                if ($fileSize > $maxFileSize) {
                    return $this->error(str(translate('File is too big, Max file size {max_file_size}', 'file system'))->replace('{max_file_size}', subscription()->formats->max_file_size));
                }
            }

            if (subscription()->plan->storage_space) {
                if ($fileSize > subscription()->storage->remaining->number) {
                    return $this->error(translate('Your storage space is not enough to upload the file', 'file system'));
                }
            }

            $location = $user ? "uploads/users/" . hashid($user->id) . "/" : "uploads/guests/";

            $handler = new $storageProvider->handler;

            $response = $handler->upload($file, $location);

            if ($response->type == "error") {
                return $this->error($response->message);
            }

            if ($response->type != "success") {
                return $this->error(str(translate('Failed to upload ({file_name})', 'file system'))->replace('{file_name}', $originalFileName));
            }

            $expiryAt = null;
            if (subscription()->plan->file_expiry_days) {
                $expiryAt = Carbon::now()->addDays(subscription()->plan->file_expiry_days);
            }

            $userId = $user ? $user->id : null;

            $name = $user ? FileEntry::getUniqueEntryName($request->name, $request->folder, $userId) : $request->name;

            $visibility = $user ? $request->visibility : 1;

            $fileEntry = FileEntry::create([
                'user_id' => $userId,
                'parent_id' => $request->folder,
                'storage_provider_id' => $storageProvider->id,
                'ip' => ipInfo()->ip,
                'name' => $name,
                'description' => $request->description,
                'filename' => $response->filename,
                'mime' => $fileMimeType,
                'size' => $fileSize,
                'extension' => strtolower($fileExtension),
                'type' => FileEntry::TYPE_FILE,
                'password' => $request->password,
                'path' => $response->path,
                'visibility' => $visibility,
                'expiry_at' => $expiryAt,
            ]);

            if (!$fileEntry) {
                return $this->error(str(translate('Failed to upload ({file_name})', 'file system'))->replace('{file_name}', $originalFileName));
            }

            $fileEntry->setPathIds();
            return $this->success([
                'shared_id' => $fileEntry->sharedId(),
                'download_link' => route('files.file', $fileEntry->sharedId()),
            ]);

        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
