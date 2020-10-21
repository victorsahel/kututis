<?php


namespace App\Traits;

use App\Support\FileEncoder;
use App\Support\TempFileManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Validation\Validator;


trait UploadsFiles2
{
    /**
     * Saves the filename in the session
     * @param string $key
     * @param string $name
     * @param string $prefix
     * @param string $ext
     */
    protected function preloadTempFile(string $key, string $name, string $prefix, string $ext)
    {
        $name = str_replace(' ', '_', $name);
        $path = "{$prefix}_{$name}.{$ext}";

        if (Storage::disk('public')->exists($path)) {
            Session::flash("{$key}_load", $path);
        }
    }

    protected function recoverFile($blob, string $name, string $prefix, string $ext)
    {
        $name = str_replace(' ', '_', $name);
        $path = "{$prefix}_{$name}.{$ext}";

        if (!Storage::disk('public')->exists($path)) {
            if ($decoded = FileEncoder::decodeFile($blob)) {
                Storage::disk('public')->put($path, $decoded);
            }
        }
    }

    /**
     * @param string $key
     * @param Request $request
     * @param Validator $validator
     * @param string $prefix
     * @return TempFileManager|null
     */
    protected function storeTempFile(string $key, Request $request, Validator $validator, bool $save = true)
    {
        $manager = null;
        $id = null;
        if (!$validator->errors()->has($key)) {
            if ($request->hasFile($key)) {
                //Si fue subido, crear una copia temporal
                $file = $request->file($key);

                $manager = TempFileManager::create($file);
                if ($save) {
                    $manager->storeData();
                }
                $id = $manager->getId();
            } else {
                //No fue subido pero existe un archivo temporal

                $id = $request->get("{$key}_tmp");
                $manager = TempFileManager::fetch($id);

            }
            Session::flash("{$key}_tmp", $id); // FIXME: tmp = id ?
        }
        if (Session::get("{$key}_load")) {
            Session::keep("{$key}_load");
        }
        return $manager;
    }

    /**
     * @deprecated
     * Get encoded value
     * @param string $key
     * @param Request $request
     * @return string|null
     */
    protected function encodeTempFile(string $key, Request $request)
    {
        $tmp_id = $request->session()->get("{$key}_tmp");
        if ($tmp_id) {
            $full_path = Storage::disk('public')->path($tmp_id);

//        if (Storage::disk('public')->exists("tmp/{$tmp_id}")) {
//
//        }

            //base64 encode
            //$mime_type = mime_content_type($full_path);

            $file_contents = file_get_contents($full_path);
            return base64_encode($file_contents);
        }
        return null;
    }

    /**
     * @deprecated
     * @param string $key
     * @param Request $request
     * @param string $prefix
     * @param string $name
     */
    protected function finishTempFile(string $key, Request $request, string $prefix, string $name)
    {
        $tmp_id = $request->session()->get("{$key}_tmp");

        $rel_path = $tmp_id;
        $file_extension = $this->getTempFileExtension($key, $request);

        //$new_file_path = "{$prefix}_{$name}.{$file_extension}";


        if (Storage::disk('public')->exists($tmp_id)) {
            Storage::disk('public')->delete($tmp_id);
        }
        //Storage::disk('public')->move($rel_path, $new_file_path);
    }

    protected function getTempFileExtension(string $key, Request $request)
    {
        $tmp_id = $request->session()->get("{$key}_tmp");
        $full_path = Storage::disk('public')->path($tmp_id);

        return pathinfo($full_path, PATHINFO_EXTENSION);
    }
}
