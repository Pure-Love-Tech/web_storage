<?php

namespace App\Traits\Files;

use League\MimeTypeDetection\GeneratedExtensionToMimeTypeMap;

trait FileLookup
{
    /**
     * Look up the file extension corresponding to a given MIME type.
     *
     * @param string $mimeType The MIME type to look up.
     * @return string|null The file extension corresponding to the given MIME type, or null if not found.
     */
    public function extension(string $mimeType): ?string
    {
        // Invert the MIME type to extension mapping and look up the extension for the given MIME type.
        $arr = array_flip(GeneratedExtensionToMimeTypeMap::MIME_TYPES_FOR_EXTENSIONS);
        return $arr[$mimeType] ?? null;
    }

    /**
     * Look up the MIME type corresponding to a given file extension.
     *
     * @param string $extension The file extension to look up.
     * @return string|null The MIME type corresponding to the given file extension, or null if not found.
     */
    public function mimeType(string $extension): ?string
    {
        // Look up the MIME type for the given file extension.
        return GeneratedExtensionToMimeTypeMap::MIME_TYPES_FOR_EXTENSIONS[$extension] ?? null;
    }
}
