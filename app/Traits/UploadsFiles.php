<?php


namespace App\Traits;

use App\Jobs\FileCleanUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

/** @deprecated   */
trait UploadsFiles
{
    protected function preloadTempFile(string $key, string $name, string $prefix, string $ext)
    {
        //$tmp_id = "tmp/".uniqid(rand(), true) . ".{$ext}";
        //$rel_path = $tmp_id;

        $name = str_replace(' ', '_', $name);

        $tmp_id = "{$prefix}_{$name}.{$ext}";

        if (Storage::disk('public')->exists($tmp_id)) {
            //Storage::disk('public')->copy("{$prefix}_{$name}.{$ext}", $rel_path);
            //FileCleanUp::dispatch($tmp_id)->delay(now()->addMinutes(3));

            //Session::flash("{$key}_tmp", $tmp_id);
            Session::flash("{$key}_load", $tmp_id);
            //Session::flash("{$key}_tmp", $tmp_id);
        }
    }

    protected function storeTempFile(string $key, Request $request, $validator, string $prefix, string $name_key, string $ext)
    {
        if (!$validator->errors()->has($key) && !$validator->errors()->has($name_key)) {

            $name = $request->input($name_key);
            $name = str_replace(' ', '_', $name);

            if ($request->hasFile($key)) {
                //Si fue subido, crear una copia temporal

                $file = $request->file($key);

                //$tmp_id = "tmp/".uniqid(rand(), true) . ".{$file->extension()}";
                $new_name = "{$prefix}_{$name}.{$file->extension()}";
                $tmp_id = $new_name;

                Storage::disk('public')->put($new_name, File::get($file));

                //TODO: delete timer
                //FileCleanUp::dispatch($tmp_id)->delay(now()->addMinutes(3));

                $request->session()->flash("{$key}_tmp", $tmp_id);
            } else {
                //No fue subido pero existe un archivo temporal
                //$request->session()->keep("{$key}_tmp");
                $tmp_id = $request->session()->get("{$key}_tmp") ?? $request->session()->get("{$key}_load");
                $new_name = "{$prefix}_{$name}.{$ext}";
                if ($tmp_id !== $new_name) {
                    if (Storage::disk('public')->exists($tmp_id)) {
                        if (Storage::disk('public')->exists($new_name)){
                            Storage::disk('public')->delete($new_name);
                        }
                        Storage::disk('public')->move($tmp_id, $new_name);
                    }
                    $tmp_id = $new_name;
                }
                Session::flash("{$key}_tmp", $tmp_id);
            }
        }
    }

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

    protected function recoverFile($blob, string $name, string $prefix, string $ext)
    {
        $name = str_replace(' ', '_', $name);

        if (!Storage::disk('public')->exists("{$prefix}_{$name}.{$ext}")) {
            $decoded = base64_decode($blob);
            $encoded = base64_encode($decoded);
            if ($encoded === $blob) {
                Storage::disk('public')->put("{$prefix}_{$name}.{$ext}", $decoded);
            }
        }
    }
}
