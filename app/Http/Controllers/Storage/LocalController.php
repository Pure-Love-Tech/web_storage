<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use App\Models\FileEntry;
use App\Traits\Files\FileEntryPartials;
use App\Traits\Files\StorageResponse;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LocalController extends Controller
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
        $this->disk = Storage::disk('public');
    }

    /**
     * Uploads a file to the specified location.
     *
     * @param  mixed  $file
     * @param  string  $location
     * @return array
     * @throws Exception
     */
    public function upload($file, string $location)
    {
        try {
            $filename = $this->generateUniqueName($file);
            $path = "app/public/{$location}";
            $upload = $file->move(storage_path($path), $filename);
            if ($upload) {
                return $this->success([
                    "filename" => $filename,
                    "path" => "{$location}{$filename}",
                ]);
            } else {
                return $this->error(translate('The upload failed due to an error in the storage provider', 'file system'));
            }
        } catch (Exception $e) {
            return $this->error(translate('The upload failed due to an error in the storage provider', 'file system'));
        }
    }

    /**
     * Downloads the specified file from the public storage disk.
     *
     * @param  FileEntry  $fileEntry
     * @return StreamedResponse
     * @throws Exception
     */
    public function download(FileEntry $fileEntry)
    {
        $filePath = $fileEntry->path;
        $fileName = $fileEntry->getFullName();
        try {
            if (!$this->disk->exists($filePath)) {
                return $this->error(translate('The requested file are not exists', 'file system'));
            }
            $headers = [
                'Content-Type' => $fileEntry->mime,
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                'Content-Length' => $fileEntry->size,
            ];
            return new StreamedResponse(function () use ($filePath) {
                $stream = $this->disk->readStream($filePath);
                while (!feof($stream) && connection_status() === 0) {
                    echo fread($stream, 1024 * 8);
                    flush();
                }
                fclose($stream);
            }, 200, $headers);
        } catch (Exception $e) {
            return $this->error(translate('The download failed due to an error on the storage provider', 'file system'));
        }
    }

    /**
     * Deletes the file at the given path from the public disk.
     *
     * @param string $path
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
