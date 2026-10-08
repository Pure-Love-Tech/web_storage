<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use App\Models\FileEntry;
use App\Traits\Files\FileEntryPartials;
use App\Traits\Files\StorageResponse;
use Carbon\Carbon;
use Exception;
use Storage;

class AmazonController extends Controller
{
    use StorageResponse, FileEntryPartials;

    /**
     * The disk instance for the file system.
     *
     * @var mixed
     */
    public $disk;

    /**
     * Constructor for creating a new instance of the class.
     * It sets the disk property to the S3 disk instance.
     */
    public function __construct()
    {
        $this->disk = Storage::disk('s3');
    }

    /**
     * Sets the credentials using the provided data.
     *
     * @param mixed $data
     * @return void
     */
    public static function setCredentials($data)
    {
        setEnv('AWS_ACCESS_KEY_ID', $data->credentials->access_key_id);
        setEnv('AWS_SECRET_ACCESS_KEY', $data->credentials->secret_access_key);
        setEnv('AWS_DEFAULT_REGION', $data->credentials->default_region);
        setEnv('AWS_BUCKET', $data->credentials->bucket);
        setEnv('AWS_URL', $data->credentials->url);
    }

    /**
     * Uploads a file to the specified location.
     *
     * @param mixed $file
     * @param string $location
     * @return array
     * @throws Exception
     */
    public function upload($file, string $location)
    {
        try {
            $filename = $this->generateUniqueName($file);
            $path = $location . $filename;
            $upload = $this->disk->put($path, fopen($file, 'r+'));
            if ($upload) {
                return $this->success([
                    "filename" => $filename,
                    "path" => $path,
                ]);
            } else {
                return $this->error(translate('The file upload failed due to an error in the storage provider', 'file system'));
            }
        } catch (Exception $e) {
            return $this->error(translate('The file upload failed due to an error in the storage provider', 'file system'));
        }
    }

    /**
     * Download the given file entry from the storage provider.
     *
     * @param  FileEntry  $fileEntry
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function download(FileEntry $fileEntry)
    {
        try {
            $fileName = $fileEntry->getFullName();
            $filePath = $fileEntry->path;
            if ($this->disk->has($filePath)) {
                $expiration = Carbon::now()->addMinutes(settings('filesystem')->download->links_expiration_time);
                $downloadLink = $this->disk->temporaryUrl($filePath, $expiration, [
                    'ResponseContentDisposition' => 'attachment; filename="' . $fileName . '"',
                ]);
                return redirect($downloadLink);
            } else {
                return $this->error(translate('The requested file are not exists', 'file system'));
            }
        } catch (Exception $e) {
            return $this->error(translate('The download failed due to an error on the storage provider', 'file system'));
        }
    }

    /**
     * Deletes the file at the given path if it exists.
     *
     * @param  string  $path
     * @return bool
     */
    public function delete($path)
    {
        if ($this->disk->has($path)) {
            $this->disk->delete($path);
        }
        return true;
    }
}
