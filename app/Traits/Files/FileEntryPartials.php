<?php

namespace App\Traits\Files;

use Illuminate\Support\Str;

trait FileEntryPartials
{
    /**
     * Generates a unique filename for a file based on the current time and a random string.
     *
     * @param \Illuminate\Http\UploadedFile $file The file to generate a name for.
     * @return string The generated filename.
     */
    public function generateUniqueName($file)
    {
        // Get the file extension from the original filename.
        $fileExtension = $file->getClientOriginalExtension();

        // Generate a random string to use as the filename prefix, and combine it
        // with the current timestamp and file extension to create a unique filename.
        $filename = Str::random(15) . '_' . time() . '.' . strtolower($fileExtension);

        // Return the generated filename.
        return $filename;
    }
}
