<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use App\Models\FileEntry;
use App\Traits\Files\FileEntryPartials;
use App\Traits\Files\StorageResponse;
use Carbon\Carbon;
use Exception;
use Storage;
use Log;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;

class CloudflareController extends Controller
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
        $this->disk = Storage::disk('cloudflare');
    }

    /**
     * Sets the credentials using the provided data.
     *
     * @param mixed $data
     * @return void
     */
    public static function setCredentials($data)
    {
        setEnv('CR2_ACCESS_KEY_ID', $data->credentials->access_key_id);
        setEnv('CR2_SECRET_ACCESS_KEY', $data->credentials->secret_access_key);
        setEnv('CR2_BUCKET', $data->credentials->bucket);
        setEnv('CR2_ENDPOINT', $data->credentials->endpoint);
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
        $totalStart = microtime(true);

        try {
            $filename = $this->generateUniqueName($file);
            $path = $location . $filename;

            $config = config('filesystems.disks.cloudflare');

            /*
         * =========================================================
         * R2 MULTIPART BENCHMARK
         * =========================================================
         *
         * Browser -> Laravel:
         *   tetap 90 MB
         *
         * Laravel -> R2:
         *   tetap 1 file stream
         *
         * R2 multipart:
         *   50 MB per part
         *
         * Concurrency:
         *   1
         *
         * Untuk test berikutnya cukup ubah:
         *
         *   50 * 1024 * 1024
         *   100 * 1024 * 1024
         *   150 * 1024 * 1024
         *
         */

            $partSizeMb = 300;
            $concurrency = 300;
            $partSize = $partSizeMb * 1024 * 1024;

            $fileSize = $file->getSize();

            \Log::info('R2_MULTIPART_START', [
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $fileSize,
                'file_size_mb' => round($fileSize / 1024 / 1024, 2),

                'part_size_mb' => $partSizeMb,
                'part_size_bytes' => $partSize,

                'concurrency' => $concurrency,

                'object_key' => $path,
            ]);

            /*
         * =========================================================
         * CREATE S3 CLIENT
         * =========================================================
         */

            $clientStart = microtime(true);

            $client = new S3Client([
                'version' => 'latest',
                'region' => $config['region'] ?? 'auto',
                'endpoint' => $config['endpoint'],

                'credentials' => [
                    'key' => $config['key'],
                    'secret' => $config['secret'],
                ],

                'use_path_style_endpoint' =>
                $config['use_path_style_endpoint'] ?? false,
            ]);

            $clientDuration = microtime(true) - $clientStart;

            \Log::info('R2_CLIENT_READY', [
                'duration_seconds' => round($clientDuration, 3),
            ]);

            /*
         * =========================================================
         * OPEN FILE STREAM
         * =========================================================
         */

            $streamStart = microtime(true);

            $stream = fopen(
                $file->getRealPath(),
                'rb'
            );

            if ($stream === false) {
                throw new Exception(
                    'Unable to open uploaded file stream.'
                );
            }

            $streamDuration = microtime(true) - $streamStart;

            \Log::info('R2_STREAM_READY', [
                'duration_seconds' => round($streamDuration, 3),
            ]);

            /*
         * =========================================================
         * CREATE MULTIPART UPLOADER
         * =========================================================
         */

            $uploaderStart = microtime(true);

            $uploader = new MultipartUploader(
                $client,
                $stream,
                [
                    'bucket' => $config['bucket'],
                    'key' => $path,

                    /*
                 * R2 multipart part size.
                 */
                    'part_size' => $partSize,

                    /*
                 * Sengaja 1 untuk baseline.
                 */
                    'concurrency' => $concurrency,
                ]
            );

            $uploaderDuration =
                microtime(true) - $uploaderStart;

            \Log::info('R2_UPLOADER_READY', [
                'duration_seconds' =>
                round($uploaderDuration, 3),

                'part_size_mb' =>
                $partSizeMb,

                'concurrency' => $concurrency,
            ]);

            /*
         * =========================================================
         * ACTUAL LARAVEL -> R2 UPLOAD
         * =========================================================
         *
         * Waktu mulai dihitung tepat sebelum upload().
         *
         * Ini yang paling penting untuk baseline:
         *
         * Laravel -> R2
         */

            $r2Start = microtime(true);

            $result = $uploader->upload();

            $r2Duration =
                microtime(true) - $r2Start;

            /*
         * Tutup stream setelah upload selesai.
         */
            if (is_resource($stream)) {
                fclose($stream);
            }

            /*
         * =========================================================
         * R2 UPLOAD FINISH
         * =========================================================
         */

            \Log::info('R2_MULTIPART_FINISH', [
                'file_name' =>
                $file->getClientOriginalName(),

                'file_size' =>
                $fileSize,

                'file_size_mb' =>
                round($fileSize / 1024 / 1024, 2),

                /*
             * PENTING:
             * Jangan hardcode 100 di sini.
             */
                'part_size_mb' =>
                $partSizeMb,

                'part_size_bytes' =>
                $partSize,

                'concurrency' => $concurrency,

                /*
             * Actual Laravel -> R2.
             */
                'duration_seconds' =>
                round($r2Duration, 3),

                'duration_minutes' =>
                round($r2Duration / 60, 3),

                'object_key' =>
                $path,

                'etag' =>
                $result['ETag'] ?? null,
            ]);

            /*
         * =========================================================
         * TOTAL FUNCTION TIME
         * =========================================================
         */

            $totalDuration =
                microtime(true) - $totalStart;

            \Log::info('R2_MULTIPART_TOTAL_FINISH', [
                'file_name' =>
                $file->getClientOriginalName(),

                'file_size' =>
                $fileSize,

                'file_size_mb' =>
                round($fileSize / 1024 / 1024, 2),

                'part_size_mb' =>
                $partSizeMb,

                'concurrency' => $concurrency,

                /*
             * Laravel -> R2.
             */
                'r2_duration_seconds' =>
                round($r2Duration, 3),

                'r2_duration_minutes' =>
                round($r2Duration / 60, 3),

                /*
             * Seluruh function upload().
             */
                'total_duration_seconds' =>
                round($totalDuration, 3),

                'total_duration_minutes' =>
                round($totalDuration / 60, 3),

                'object_key' =>
                $path,
            ]);

            /*
         * =========================================================
         * SUCCESS
         * =========================================================
         */

            if ($result) {
                return $this->success([
                    'filename' => $filename,
                    'path' => $path,
                ]);
            }

            return $this->error(
                lang(
                    'The file upload failed due to an error in the storage provider',
                    'file system'
                )
            );
        } catch (Exception $e) {

            /*
         * Pastikan stream ditutup jika terjadi error.
         */
            if (isset($stream) && is_resource($stream)) {
                fclose($stream);
            }

            $totalDuration =
                microtime(true) - $totalStart;

            \Log::error('R2_MULTIPART_ERROR', [
                'file_name' =>
                $file->getClientOriginalName() ?? null,

                'file_size' =>
                $file->getSize() ?? null,

                'part_size_mb' =>
                $partSizeMb ?? null,

                'concurrency' => $concurrency,

                'duration_seconds' =>
                round($totalDuration, 3),

                'message' =>
                $e->getMessage(),

                'exception' =>
                get_class($e),
            ]);

            return $this->error(
                lang(
                    'The file upload failed due to an error in the storage provider',
                    'file system'
                )
            );
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
                return $this->error(lang('The requested file are not exists', 'file system'));
            }
        } catch (Exception $e) {
            return $this->error(lang('The download failed due to an error on the storage provider', 'file system'));
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

    //new fitur direct upload R2

    /**
     * Membuat S3 client khusus untuk direct upload ke Cloudflare R2.
     *
     * Method lama upload() tetap dipertahankan.
     */
    private function directS3Client(): S3Client
    {
        $config = config('filesystems.disks.cloudflare');

        return new S3Client([
            'version' => 'latest',
            'region' => $config['region'] ?? 'auto',
            'endpoint' => $config['endpoint'],

            'credentials' => [
                'key' => $config['key'],
                'secret' => $config['secret'],
            ],

            'use_path_style_endpoint' =>
            $config['use_path_style_endpoint'] ?? false,
        ]);
    }


    /**
     * Membuat multipart upload baru di R2.
     */
    public function createDirectMultipartUpload(
        string $path,
        ?string $contentType = null
    ): array {
        $client = $this->directS3Client();

        $config = config('filesystems.disks.cloudflare');

        $params = [
            'Bucket' => $config['bucket'],
            'Key' => $path,
        ];

        if (!empty($contentType)) {
            $params['ContentType'] = $contentType;
        }

        $result = $client->createMultipartUpload($params);

        if (empty($result['UploadId'])) {
            throw new Exception(
                'R2 did not return multipart UploadId.'
            );
        }

        return [
            'upload_id' => (string) $result['UploadId'],
            'path' => $path,
        ];
    }


    /**
     * Membuat presigned PUT URL untuk satu multipart part.
     */
    public function createDirectPartUrl(
        string $path,
        string $uploadId,
        int $partNumber,
        ?int $expiresMinutes = null
    ): string {

        if (
            $partNumber < 1 ||
            $partNumber >
            (int) config(
                'direct_upload.max_parts',
                10000
            )
        ) {

            throw new Exception(
                'Invalid multipart part number.'
            );
        }


        /*
     * Jika caller tidak menentukan expiry,
     * ambil dari config.
     */
        if ($expiresMinutes === null) {

            $expiresMinutes =
                (int) config(
                    'direct_upload.presigned_expire_minutes',
                    15
                );
        }


        if ($expiresMinutes < 1) {

            throw new Exception(
                'Invalid presigned URL expiration.'
            );
        }


        $client =
            $this->directS3Client();


        $config =
            config(
                'filesystems.disks.cloudflare'
            );


        $command =
            $client->getCommand(
                'UploadPart',
                [
                    'Bucket' =>
                    $config['bucket'],

                    'Key' =>
                    $path,

                    'UploadId' =>
                    $uploadId,

                    'PartNumber' =>
                    $partNumber,
                ]
            );


        $request =
            $client->createPresignedRequest(
                $command,
                '+' .
                    $expiresMinutes .
                    ' minutes'
            );


        return (string)
        $request->getUri();
    }


    /**
     * Menyelesaikan multipart upload.
     *
     * $parts harus berbentuk:
     *
     * [
     *     [
     *         'PartNumber' => 1,
     *         'ETag' => '"xxxxx"',
     *     ],
     *     ...
     * ]
     */
    public function completeDirectMultipartUpload(
        string $path,
        string $uploadId,
        array $parts
    ) {
        if (empty($parts)) {
            throw new Exception(
                'Multipart upload parts cannot be empty.'
            );
        }

        usort($parts, function ($a, $b) {
            return ((int) $a['PartNumber']) <=>
                ((int) $b['PartNumber']);
        });

        $client = $this->directS3Client();

        $config = config('filesystems.disks.cloudflare');

        return $client->completeMultipartUpload([
            'Bucket' => $config['bucket'],
            'Key' => $path,
            'UploadId' => $uploadId,

            'MultipartUpload' => [
                'Parts' => $parts,
            ],
        ]);
    }


    /**
     * Membatalkan multipart upload yang belum selesai.
     */
    public function abortDirectMultipartUpload(
        string $path,
        string $uploadId
    ): bool {
        try {
            $client = $this->directS3Client();

            $config = config('filesystems.disks.cloudflare');

            $client->abortMultipartUpload([
                'Bucket' => $config['bucket'],
                'Key' => $path,
                'UploadId' => $uploadId,
            ]);

            return true;
        } catch (\Throwable $e) {

            Log::warning('R2_DIRECT_ABORT_ERROR', [
                'path' => $path,
                'upload_id' => $uploadId,
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }


    /**
     * Memastikan object benar-benar sudah ada di R2.
     */
    public function headDirectObject(string $path)
    {
        $client = $this->directS3Client();

        $config = config('filesystems.disks.cloudflare');

        return $client->headObject([
            'Bucket' => $config['bucket'],
            'Key' => $path,
        ]);
    }
}
