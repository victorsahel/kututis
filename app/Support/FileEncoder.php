<?php


namespace App\Support;


use Illuminate\Http\UploadedFile;

class FileEncoder
{
    /**
     * @param $file
     * @return string
     */
    static function encodeFile(UploadedFile $file) {
        $content = file_get_contents($file->getRealPath());
        return base64_encode($content);
    }

    /**
     * @param string $base64
     * @param bool $check
     * @return string|null
     */
    static function decodeFile(string $base64, bool $check = true) {
        if ($decoded = base64_decode($base64)) {
            if (!$check) {
                return $decoded;
            }
            $encoded = base64_encode($decoded);
            if ($encoded === $base64) {
                return $decoded;
            }
        }
        return null;
    }

    /**
     * @param string $decoded
     * @return array
     */
    static function getFileInfo(string $decoded) {
        $f = finfo_open();

        return [
            'mime_type' => finfo_buffer($f, $decoded, FILEINFO_EXTENSION),
            'extension' => finfo_buffer($f, $decoded, FILEINFO_EXTENSION)
        ];

    }
}
