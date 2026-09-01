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
use App\Models\UploadSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
        $uploadStartedAt = microtime(true);
        $uploadId = (string) str()->uuid();

        logger()->info('UPLOAD_START', [
            'upload_id' => $uploadId,
            'user_id' => $user?->id,
            'file_name' => $request->file('file')?->getClientOriginalName(),
            'file_size' => $request->file('file')?->getSize(),
        ]);
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

            $receiveStartedAt = microtime(true);

            logger()->info('UPLOAD_RECEIVE_START', [
                'upload_id' => $uploadId,
            ]);

            $save = $receiver->receive();

            $receiveDuration = microtime(true) - $receiveStartedAt;

            logger()->info('UPLOAD_RECEIVE_FINISH', [
                'upload_id' => $uploadId,
                'duration_seconds' => round($receiveDuration, 3),
                'finished' => $save->isFinished(),
            ]);

            if (!$save->isFinished()) {
                return $this->error(str(translate('Failed to upload ({file_name})', 'file system'))->replace('{file_name}', $originalFileName));
            }

            $file = $save->getFile();

            logger()->info('UPLOAD_FILE_READY', [
                'upload_id' => $uploadId,
                'file_size' => $file->getSize(),
                'file_path' => $file->getRealPath(),
                'duration_seconds' => round(microtime(true) - $uploadStartedAt, 3),
            ]);

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

            $r2StartedAt = microtime(true);

            logger()->info('UPLOAD_R2_START', [
                'upload_id' => $uploadId,
                'file_size' => $fileSize,
                'storage_provider' => $storageProvider->id,
            ]);

            $response = $handler->upload($file, $location);

            $r2Duration = microtime(true) - $r2StartedAt;

            logger()->info('UPLOAD_R2_FINISH', [
                'upload_id' => $uploadId,
                'duration_seconds' => round($r2Duration, 3),
                'response_type' => $response->type ?? null,
                'total_duration_seconds' => round(microtime(true) - $uploadStartedAt, 3),
            ]);

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

            $dbStartedAt = microtime(true);

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

            logger()->info('UPLOAD_DATABASE_FINISH', [
                'upload_id' => $uploadId,
                'duration_seconds' => round(microtime(true) - $dbStartedAt, 3),
            ]);

            if (!$fileEntry) {
                return $this->error(str(translate('Failed to upload ({file_name})', 'file system'))->replace('{file_name}', $originalFileName));
            }

            $fileEntry->setPathIds();

            logger()->info('UPLOAD_FINISH', [
                'upload_id' => $uploadId,
                'total_duration_seconds' => round(microtime(true) - $uploadStartedAt, 3),
            ]);

            return $this->success([
                'shared_id' => $fileEntry->sharedId(),
                'download_link' => route('files.file', $fileEntry->sharedId()),
            ]);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    //new
    public function directInitiate(Request $request)
    {
        if (subscription()->is_expired) {
            return $this->error(
                translate(
                    'Your subscription has expired',
                    'settings'
                )
            );
        }

        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'original_name' => [
                'required',
                'string',
                'max:255',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
                'block_patterns',
            ],

            'size' => [
                'required',
                'integer',
                'min:1',
            ],

            'mime' => [
                'nullable',
                'string',
                'max:255',
            ],

            'visibility' => [
                'nullable',
                'boolean',
            ],

            'password' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
                'block_patterns',
            ],

            'folder' => [
                'nullable',
                'integer',
            ],
        ]);

        if ($validator->fails()) {
            return $this->error(
                $validator->errors()->first()
            );
        }

        /*
     * =========================================================
     * VALIDASI FOLDER
     * =========================================================
     */

        if ($request->filled('folder')) {

            if (!$user) {
                return $this->error(
                    translate(
                        'Invalid folder',
                        'file system'
                    )
                );
            }

            $folderExists = FileEntry::query()
                ->where('id', $request->folder)
                ->where('user_id', $user->id)
                ->where('type', FileEntry::TYPE_FOLDER)
                ->exists();

            if (!$folderExists) {
                return $this->error(
                    translate(
                        'Invalid folder',
                        'file system'
                    )
                );
            }
        }

        /*
     * =========================================================
     * FILE INFO
     * =========================================================
     */

        $originalFileName = basename(
            $request->original_name
        );

        $fileSize = (int) $request->size;

        $fileExtension = strtolower(
            pathinfo(
                $originalFileName,
                PATHINFO_EXTENSION
            )
        );

        /*
     * =========================================================
     * VALIDASI EXTENSION
     *
     * Mengikuti behavior upload() lama.
     * =========================================================
     */

        if (!settings('filesystem')->upload->types->status) {

            $extensions = explode(
                ',',
                settings(
                    'filesystem'
                )->upload->types->extensions
            );

            $extensions = array_map(
                function ($extension) {
                    return strtolower(trim($extension));
                },
                $extensions
            );

            if (
                !in_array(
                    $fileExtension,
                    $extensions,
                    true
                )
            ) {
                return $this->error(
                    translate(
                        'You cannot upload files of this type',
                        'file system'
                    )
                );
            }
        }

        /*
     * =========================================================
     * MAX FILE SIZE
     * =========================================================
     */

        $maxFileSize =
            subscription()->upload->max_file_size;

        if (
            $maxFileSize &&
            $fileSize > $maxFileSize
        ) {
            return $this->error(
                str(
                    translate(
                        'File is too big, Max file size {max_file_size}',
                        'file system'
                    )
                )->replace(
                    '{max_file_size}',
                    subscription()->formats->max_file_size
                )
            );
        }

        /*
     * =========================================================
     * STORAGE QUOTA + RESERVED UPLOAD
     * =========================================================
     */

        if (subscription()->plan->storage_space) {

            $remainingStorage =
                (int) subscription()
                    ->storage
                    ->remaining
                    ->number;

            $reservedStorage =
                $this->getReservedDirectUploadBytes(
                    $user?->id,
                    ipInfo()->ip
                );

            $availableStorage =
                max(
                    0,
                    $remainingStorage - $reservedStorage
                );

            if ($fileSize > $availableStorage) {

                return $this->error(
                    translate(
                        'Your storage space is not enough to upload the file',
                        'file system'
                    )
                );
            }
        }

        /*
     * =========================================================
     * STORAGE PROVIDER
     * =========================================================
     */

        $storageProvider =
            StorageProvider::default()
            ->active()
            ->first();

        if (!$storageProvider) {
            return $this->error(
                translate(
                    'Unavailable storage provider',
                    'file system'
                )
            );
        }

        $handler = new $storageProvider->handler;

        if (
            !method_exists(
                $handler,
                'createDirectMultipartUpload'
            )
        ) {
            return $this->error(
                'The current storage provider does not support direct multipart upload.'
            );
        }

        /*
     * =========================================================
     * MIME
     * =========================================================
     */

        $fileMimeType = null;

        if ($fileExtension !== '') {
            $fileMimeType =
                $this->mimeType($fileExtension);
        }

        if (!$fileMimeType) {
            $fileMimeType =
                $request->mime
                ?: 'application/octet-stream';
        }

        /*
     * =========================================================
     * OBJECT NAME
     * =========================================================
     */

        $filename =
            (string) Str::uuid();

        if ($fileExtension !== '') {
            $filename .= '.' . $fileExtension;
        }

        $location = $user
            ? 'uploads/users/'
            . hashid($user->id)
            . '/'
            : 'uploads/guests/';

        $path = $location . $filename;

        /*
     * =========================================================
     * MULTIPART SIZE
     * =========================================================
     */

        try {
            $partSize =
                $this->calculateDirectPartSize(
                    $fileSize
                );
        } catch (\Throwable $e) {
            return $this->error(
                $e->getMessage()
            );
        }

        $totalParts = (int) ceil(
            $fileSize / $partSize
        );

        $maxParts =
            (int) config(
                'direct_upload.max_parts',
                10000
            );


        if (
            $totalParts < 1 ||
            $totalParts > $maxParts
        ) {

            return $this->error(
                'Invalid multipart part count.'
            );
        }

        /*
     * =========================================================
     * CREATE R2 MULTIPART
     * =========================================================
     */

        try {

            $multipart =
                $handler->createDirectMultipartUpload(
                    $path,
                    $fileMimeType
                );
        } catch (\Throwable $e) {

            logger()->error(
                'DIRECT_UPLOAD_INIT_R2_ERROR',
                [
                    'user_id' => $user?->id,
                    'file_name' => $originalFileName,
                    'file_size' => $fileSize,
                    'message' => $e->getMessage(),
                ]
            );

            return $this->error(
                'Unable to initialize R2 upload.'
            );
        }

        /*
     * =========================================================
     * CREATE UPLOAD SESSION
     * =========================================================
     */

        try {

            $session = UploadSession::create([
                'token' =>
                (string) Str::uuid(),

                'user_id' =>
                $user?->id,

                'storage_provider_id' =>
                $storageProvider->id,

                'r2_upload_id' =>
                $multipart['upload_id'],

                'object_key' =>
                $path,

                'filename' =>
                $filename,

                'original_name' =>
                $originalFileName,

                'name' =>
                $request->name,

                'mime' =>
                $fileMimeType,

                'extension' =>
                $fileExtension,

                'size' =>
                $fileSize,

                'part_size' =>
                $partSize,

                'total_parts' =>
                $totalParts,

                'parent_id' =>
                $request->folder,

                'visibility' =>
                $user
                    ? (bool) $request->visibility
                    : true,

                'password' =>
                $request->password,

                'description' =>
                $request->description,

                'ip' =>
                ipInfo()->ip,

                'status' =>
                UploadSession::STATUS_INITIATED,

                /*
             * Upload session hidup 6 jam.
             *
             * Presigned URL per part tetap hanya 15 menit.
             */
                'expires_at' =>
                now()->addHours(
                    (int) config(
                        'direct_upload.session_expire_hours',
                        6
                    )
                ),
            ]);
        } catch (\Throwable $e) {

            $handler->abortDirectMultipartUpload(
                $path,
                $multipart['upload_id']
            );

            logger()->error(
                'DIRECT_UPLOAD_SESSION_ERROR',
                [
                    'message' => $e->getMessage(),
                    'path' => $path,
                ]
            );

            return $this->error(
                'Unable to create upload session.'
            );
        }

        logger()->info(
            'DIRECT_UPLOAD_INIT',
            [
                'token' => $session->token,
                'user_id' => $user?->id,
                'file_name' => $originalFileName,
                'file_size' => $fileSize,
                'part_size' => $partSize,
                'total_parts' => $totalParts,
                'path' => $path,
            ]
        );

        return $this->success([
            'token' =>
            $session->token,

            'part_size' =>
            $session->part_size,

            'total_parts' =>
            $session->total_parts,

            'expires_at' =>
            $session->expires_at
                ->toIso8601String(),
        ]);
    }

    public function directPartUrl(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'token' => [
                    'required',
                    'uuid',
                ],

                'part_number' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:' . config(
                        'direct_upload.max_parts',
                        10000
                    ),
                ],
            ]
        );

        if ($validator->fails()) {
            return $this->error(
                $validator->errors()->first()
            );
        }

        $session =
            $this->findDirectUploadSession(
                $request->token
            );

        if (!$session) {
            return $this->error(
                'Invalid upload session.'
            );
        }

        if ($session->isExpired()) {

            $this->abortDirectSession($session);

            return $this->error(
                'Upload session has expired.'
            );
        }

        if (
            !in_array(
                $session->status,
                [
                    UploadSession::STATUS_INITIATED,
                    UploadSession::STATUS_UPLOADING,
                ],
                true
            )
        ) {
            return $this->error(
                'Upload session is not available.'
            );
        }

        $partNumber =
            (int) $request->part_number;

        if (
            $partNumber >
            $session->total_parts
        ) {
            return $this->error(
                'Invalid multipart part number.'
            );
        }

        $storageProvider =
            StorageProvider::find(
                $session->storage_provider_id
            );

        if (!$storageProvider) {
            return $this->error(
                'Storage provider does not exist.'
            );
        }

        $handler =
            new $storageProvider->handler;

        if (
            !method_exists(
                $handler,
                'createDirectPartUrl'
            )
        ) {
            return $this->error(
                'Storage provider does not support direct upload.'
            );
        }

        try {

            $presignedExpireMinutes =
                (int) config(
                    'direct_upload.presigned_expire_minutes',
                    15
                );


            $url =
                $handler->createDirectPartUrl(
                    $session->object_key,
                    $session->r2_upload_id,
                    $partNumber,
                    $presignedExpireMinutes
                );

            $session->update([
                'status' =>
                UploadSession::STATUS_UPLOADING,

                /*
             * Selama user masih aktif upload,
             * session diperpanjang.
             */
                'expires_at' =>
                now()->addHours(
                    (int) config(
                        'direct_upload.session_expire_hours',
                        6
                    )
                ),
            ]);

            return $this->success([
                'url' => $url,
                'part_number' => $partNumber,
            ]);
        } catch (\Throwable $e) {

            logger()->error(
                'DIRECT_UPLOAD_PART_URL_ERROR',
                [
                    'token' => $session->token,
                    'part_number' => $partNumber,
                    'message' => $e->getMessage(),
                ]
            );

            return $this->error(
                'Unable to create upload URL.'
            );
        }
    }

    public function directComplete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'token' => [
                    'required',
                    'uuid',
                ],

                'parts' => [
                    'required',
                    'array',
                    'min:1',
                    'max:' . config(
                        'direct_upload.max_parts',
                        10000
                    ),
                ],

                'parts.*.part_number' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:' . config(
                        'direct_upload.max_parts',
                        10000
                    ),
                ],

                'parts.*.etag' => [
                    'required',
                    'string',
                    'max:255',
                ],
            ]
        );

        if ($validator->fails()) {
            return $this->error(
                $validator->errors()->first()
            );
        }

        $session =
            $this->findDirectUploadSession(
                $request->token
            );

        if (!$session) {
            return $this->error(
                'Invalid upload session.'
            );
        }

        /*
     * Idempotent response.
     *
     * Jika complete sudah berhasil tetapi browser
     * kehilangan response, request kedua tetap
     * mendapat link file.
     */
        if (
            $session->status ===
            UploadSession::STATUS_COMPLETED &&
            $session->file_entry_id
        ) {
            $fileEntry =
                FileEntry::find(
                    $session->file_entry_id
                );

            if ($fileEntry) {
                return $this->success([
                    'shared_id' =>
                    $fileEntry->sharedId(),

                    'download_link' =>
                    route(
                        'files.file',
                        $fileEntry->sharedId()
                    ),
                ]);
            }
        }

        if ($session->isExpired()) {

            $this->abortDirectSession($session);

            return $this->error(
                'Upload session has expired.'
            );
        }

        if (
            !in_array(
                $session->status,
                [
                    UploadSession::STATUS_INITIATED,
                    UploadSession::STATUS_UPLOADING,
                ],
                true
            )
        ) {
            return $this->error(
                'Upload session cannot be completed.'
            );
        }

        /*
     * =========================================================
     * NORMALIZE PARTS
     * =========================================================
     */

        $parts = [];

        foreach ($request->parts as $part) {

            $parts[] = [
                'PartNumber' =>
                (int) $part['part_number'],

                /*
             * Jangan remove quote pada ETag.
             *
             * Kita kirim kembali value persis
             * seperti response R2.
             */
                'ETag' =>
                (string) $part['etag'],
            ];
        }

        usort(
            $parts,
            function ($a, $b) {
                return $a['PartNumber']
                    <=> $b['PartNumber'];
            }
        );

        /*
     * Jumlah part harus sama.
     */
        if (
            count($parts) !==
            (int) $session->total_parts
        ) {
            return $this->error(
                'Multipart upload is incomplete.'
            );
        }

        /*
     * Part harus:
     *
     * 1, 2, 3, 4...
     *
     * Tidak boleh duplicate / hilang.
     */
        foreach (
            $parts as $index => $part
        ) {
            $expectedPart =
                $index + 1;

            if (
                $part['PartNumber'] !==
                $expectedPart
            ) {
                return $this->error(
                    'Invalid multipart part sequence.'
                );
            }
        }

        $storageProvider =
            StorageProvider::find(
                $session->storage_provider_id
            );

        if (!$storageProvider) {
            return $this->error(
                'Storage provider does not exist.'
            );
        }

        $handler =
            new $storageProvider->handler;

        /*
     * Lock state.
     */
        $session->update([
            'status' =>
            UploadSession::STATUS_COMPLETING,
        ]);

        /*
     * =========================================================
     * COMPLETE R2 MULTIPART
     * =========================================================
     */

        try {

            $handler->completeDirectMultipartUpload(
                $session->object_key,
                $session->r2_upload_id,
                $parts
            );
        } catch (\Throwable $e) {

            $session->update([
                'status' =>
                UploadSession::STATUS_UPLOADING,

                'error' =>
                $e->getMessage(),
            ]);

            logger()->error(
                'DIRECT_UPLOAD_COMPLETE_R2_ERROR',
                [
                    'token' => $session->token,
                    'path' => $session->object_key,
                    'message' => $e->getMessage(),
                ]
            );

            return $this->error(
                'Unable to complete R2 multipart upload.'
            );
        }

        /*
     * =========================================================
     * HEAD OBJECT
     *
     * Browser mengatakan size sekian tidak kita percaya.
     *
     * Setelah object benar-benar selesai,
     * tanyakan ContentLength langsung ke R2.
     * =========================================================
     */

        try {

            $head =
                $handler->headDirectObject(
                    $session->object_key
                );

            $actualSize =
                (int) (
                    $head['ContentLength']
                    ?? -1
                );
        } catch (\Throwable $e) {

            $handler->delete(
                $session->object_key
            );

            $session->update([
                'status' =>
                UploadSession::STATUS_FAILED,

                'error' =>
                'Unable to verify R2 object.',
            ]);

            return $this->error(
                'Unable to verify uploaded file.'
            );
        }

        /*
     * =========================================================
     * SIZE VERIFICATION
     * =========================================================
     */

        if (
            $actualSize !==
            (int) $session->size
        ) {

            $handler->delete(
                $session->object_key
            );

            $session->update([
                'status' =>
                UploadSession::STATUS_FAILED,

                'error' =>
                'Uploaded object size mismatch.',
            ]);

            logger()->warning(
                'DIRECT_UPLOAD_SIZE_MISMATCH',
                [
                    'token' => $session->token,
                    'expected' => $session->size,
                    'actual' => $actualSize,
                ]
            );

            return $this->error(
                'Uploaded file size verification failed.'
            );
        }

        /*
     * =========================================================
     * FINAL QUOTA CHECK
     * =========================================================
     *
     * Ini penting karena selama upload berlangsung
     * user mungkin juga upload melalui flow lama.
     */

        if (
            subscription()->plan->storage_space
        ) {

            $remaining =
                (int) subscription()
                    ->storage
                    ->remaining
                    ->number;

            if (
                (int) $session->size >
                $remaining
            ) {

                $handler->delete(
                    $session->object_key
                );

                $session->update([
                    'status' =>
                    UploadSession::STATUS_FAILED,

                    'error' =>
                    'Storage quota exceeded during upload.',
                ]);

                return $this->error(
                    translate(
                        'Your storage space is not enough to upload the file',
                        'file system'
                    )
                );
            }
        }

        /*
     * =========================================================
     * CREATE FILE ENTRY
     * =========================================================
     */

        try {

            $fileEntry =
                DB::transaction(
                    function () use (
                        $session
                    ) {

                        $userId =
                            $session->user_id;

                        if ($userId) {

                            $name =
                                FileEntry::getUniqueEntryName(
                                    $session->name,
                                    $session->parent_id,
                                    $userId
                                );
                        } else {

                            $name =
                                $session->name;
                        }

                        $expiryAt = null;

                        if (
                            subscription()
                            ->plan
                            ->file_expiry_days
                        ) {

                            $expiryAt =
                                Carbon::now()
                                ->addDays(
                                    subscription()
                                        ->plan
                                        ->file_expiry_days
                                );
                        }

                        $fileEntry =
                            FileEntry::create([
                                'user_id' =>
                                $userId,

                                'parent_id' =>
                                $session->parent_id,

                                'storage_provider_id' =>
                                $session
                                    ->storage_provider_id,

                                'ip' =>
                                $session->ip,

                                'name' =>
                                $name,

                                'description' =>
                                $session->description,

                                'filename' =>
                                $session->filename,

                                'mime' =>
                                $session->mime,

                                'size' =>
                                $session->size,

                                'extension' =>
                                strtolower(
                                    $session->extension
                                ),

                                'type' =>
                                FileEntry::TYPE_FILE,

                                'password' =>
                                $session->password,

                                'path' =>
                                $session->object_key,

                                'visibility' =>
                                $session->visibility,

                                'expiry_at' =>
                                $expiryAt,
                            ]);

                        $fileEntry->setPathIds();

                        $session->update([
                            'file_entry_id' =>
                            $fileEntry->id,

                            'status' =>
                            UploadSession::STATUS_COMPLETED,

                            'completed_at' =>
                            now(),

                            'error' =>
                            null,
                        ]);

                        return $fileEntry;
                    }
                );
        } catch (\Throwable $e) {

            /*
         * Object sudah ada di R2 tetapi DB gagal.
         *
         * Jangan tinggalkan orphan object.
         */
            $handler->delete(
                $session->object_key
            );

            $session->update([
                'status' =>
                UploadSession::STATUS_FAILED,

                'error' =>
                $e->getMessage(),
            ]);

            logger()->error(
                'DIRECT_UPLOAD_DATABASE_ERROR',
                [
                    'token' => $session->token,
                    'message' => $e->getMessage(),
                ]
            );

            return $this->error(
                'Unable to save uploaded file.'
            );
        }

        logger()->info(
            'DIRECT_UPLOAD_FINISH',
            [
                'token' => $session->token,
                'file_entry_id' => $fileEntry->id,
                'file_size' => $session->size,
                'path' => $session->object_key,
            ]
        );

        /*
     * Response sengaja sama dengan upload lama.
     *
     * Supaya UI bagian akhir tidak perlu berubah
     * secara konseptual.
     */
        return $this->success([
            'shared_id' =>
            $fileEntry->sharedId(),

            'download_link' =>
            route(
                'files.file',
                $fileEntry->sharedId()
            ),
        ]);
    }

    public function directAbort(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'token' => [
                    'required',
                    'uuid',
                ],
            ]
        );

        if ($validator->fails()) {
            return $this->error(
                $validator->errors()->first()
            );
        }

        $session =
            $this->findDirectUploadSession(
                $request->token
            );

        if (!$session) {
            return $this->error(
                'Invalid upload session.'
            );
        }

        /*
     * Kalau sudah completed jangan delete.
     */
        if (
            $session->status ===
            UploadSession::STATUS_COMPLETED
        ) {
            return $this->success([
                'aborted' => false,
            ]);
        }

        $this->abortDirectSession(
            $session
        );

        return $this->success([
            'aborted' => true,
        ]);
    }

    /**
     * Mencari upload session milik request sekarang.
     *
     * Logged-in:
     * token + user_id
     *
     * Guest:
     * token + IP
     */
    private function findDirectUploadSession(
        string $token
    ): ?UploadSession {

        $query =
            UploadSession::where(
                'token',
                $token
            );

        $user = auth()->user();

        if ($user) {

            $query->where(
                'user_id',
                $user->id
            );
        } else {

            $query
                ->whereNull('user_id')
                ->where(
                    'ip',
                    ipInfo()->ip
                );
        }

        return $query->first();
    }


    /**
     * Berapa byte yang sedang "reserved"
     * oleh direct upload yang belum selesai.
     */
    private function getReservedDirectUploadBytes(
        ?int $userId,
        ?string $ip
    ): int {

        $query =
            UploadSession::query()
            ->whereIn(
                'status',
                [
                    UploadSession::STATUS_INITIATED,

                    UploadSession::STATUS_UPLOADING,

                    UploadSession::STATUS_COMPLETING,
                ]
            )
            ->where(
                'expires_at',
                '>',
                now()
            );

        if ($userId) {

            $query->where(
                'user_id',
                $userId
            );
        } else {

            $query
                ->whereNull('user_id')
                ->where(
                    'ip',
                    $ip
                );
        }

        return (int) $query->sum('size');
    }


    /**
     * Part size.
     *
     * Default 25 MiB.
     *
     * Tetapi jika suatu saat max file sangat besar,
     * size otomatis dinaikkan supaya jumlah part
     * tetap <= 10.000.
     */
    private function calculateDirectPartSize(
        int $fileSize
    ): int {

        $oneMiB =
            1024 * 1024;


        /*
     * =========================================================
     * CONFIG
     * =========================================================
     */

        $preferredPartSizeMb =
            (int) config(
                'direct_upload.part_size_mb',
                50
            );


        $minPartSizeMb =
            (int) config(
                'direct_upload.min_part_size_mb',
                5
            );


        $maxPartSizeMb =
            (int) config(
                'direct_upload.max_part_size_mb',
                5120
            );


        $maxParts =
            (int) config(
                'direct_upload.max_parts',
                10000
            );


        /*
     * =========================================================
     * CONFIG VALIDATION
     * =========================================================
     */

        if ($maxParts < 1) {

            throw new Exception(
                'DIRECT_UPLOAD_MAX_PARTS must be greater than 0.'
            );
        }


        if ($minPartSizeMb < 1) {

            throw new Exception(
                'DIRECT_UPLOAD_MIN_PART_SIZE_MB must be greater than 0.'
            );
        }


        if (
            $preferredPartSizeMb <
            $minPartSizeMb
        ) {

            $preferredPartSizeMb =
                $minPartSizeMb;
        }


        if (
            $maxPartSizeMb <
            $minPartSizeMb
        ) {

            throw new Exception(
                'DIRECT_UPLOAD_MAX_PART_SIZE_MB is invalid.'
            );
        }


        /*
     * =========================================================
     * BYTES
     * =========================================================
     */

        $preferredPartSize =
            $preferredPartSizeMb *
            $oneMiB;


        $maxPartSize =
            $maxPartSizeMb *
            $oneMiB;


        /*
     * Minimum size agar jumlah part
     * tidak melebihi MAX_PARTS.
     */
        $requiredPartSize =
            (int) ceil(
                $fileSize /
                    $maxParts
            );


        $partSize =
            max(
                $preferredPartSize,
                $requiredPartSize
            );


        /*
     * Round ke atas per MiB.
     */
        $partSize =
            (int) (
                ceil(
                    $partSize /
                        $oneMiB
                ) *
                $oneMiB
            );


        /*
     * Jangan melebihi batas multipart.
     */
        if (
            $partSize >
            $maxPartSize
        ) {

            throw new Exception(
                'File is too large for multipart upload.'
            );
        }


        return $partSize;
    }

    /**
     * Abort session sekaligus update database.
     */
    private function abortDirectSession(
        UploadSession $session
    ): void {

        try {

            $storageProvider =
                StorageProvider::find(
                    $session
                        ->storage_provider_id
                );

            if ($storageProvider) {

                $handler =
                    new $storageProvider->handler;

                if (
                    method_exists(
                        $handler,
                        'abortDirectMultipartUpload'
                    )
                ) {

                    $handler
                        ->abortDirectMultipartUpload(
                            $session->object_key,
                            $session->r2_upload_id
                        );
                }
            }
        } catch (\Throwable $e) {

            logger()->warning(
                'DIRECT_UPLOAD_ABORT_ERROR',
                [
                    'token' => $session->token,
                    'message' => $e->getMessage(),
                ]
            );
        }

        $session->update([
            'status' =>
            UploadSession::STATUS_ABORTED,
        ]);
    }
}
