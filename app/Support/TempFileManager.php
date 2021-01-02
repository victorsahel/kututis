<?php


namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class TempFileManager
{
    private $id;
    private $base64;
    private $ext;
    private $storage_path;

    /**
     * TempFileManager constructor.
     * @param string $id
     * @param string $base64
     * @param string $ext
     */
    private function __construct(string $id, string $base64, string $ext)
    {
        $this->id = $id;
        $this->ext = $ext;
        $this->base64 = $base64;
        $this->storage_path = '';
    }

    /**
     * @param UploadedFile $file
     * @return TempFileManager
     */
    static function create(UploadedFile $file)
    {
        $id = self::generateId();
        $ext = self::obtainExtension($file);
        $base64 = FileEncoder::encodeFile($file);
        return new TempFileManager($id, $base64, $ext);
    }

    /**
     * @param string $id
     * @return TempFileManager|null
     */
    static function fetch(string $id)
    {
        $data = Cache::get($id);
        if ($data) {
            return new TempFileManager($id, $data['base64'], $data['ext']);
        }
        return null;
    }

    function override(UploadedFile $file)
    {
        $this->ext = self::obtainExtension($file);
        $this->base64 = FileEncoder::encodeFile($file);
        return $this->storeData();
    }

    /**
     * @return $this
     */
    function storeData()
    {
        $data = [
            'base64' => $this->base64,
            'ext' => $this->ext
        ];
        Cache::put($this->id, $data, 5 * 60);
        return $this;
    }

    function finish(string $name, string $prefix = '')
    {
        $name = str_replace(' ', '_', $name);
        $path = "{$this->storage_path}/{$prefix}{$name}.{$this->ext}";
        self::saveFile($this->base64, $path);
    }

    /**
     * @param string $base64
     * @param string $path
     * @return bool|string
     */
    private static function saveFile(string $base64, string $path)
    {
        if (!Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
        if ($decoded = FileEncoder::decodeFile($base64)) {
            return Storage::disk('public')->put($path, $decoded);
        }
        return false;
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    private static function obtainExtension(UploadedFile $file)
    {
        return $file->guessClientExtension();
    }

    /**
     * @return string
     */
    private static function generateId()
    {
        return uniqid(rand(), true);
    }

    /**
     * @param string $path
     * @return TempFileManager
     */
    function setStoragePath(string $path)
    {
        $this->storage_path = rtrim($path, '/');
        return $this;
    }

    /**
     * @return string
     */
    function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    function getBase64()
    {
        return $this->base64;
    }

    /**
     * @return string
     */
    function getExtension()
    {
        return $this->ext;
    }
}
