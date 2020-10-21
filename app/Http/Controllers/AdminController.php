<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiPostRequestException;
use App\Helpers\Jwt;
use App\Support\Token;
use App\Traits\UploadsFiles;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Controllers;
use Illuminate\Http\Request;
use Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Validator;

class AdminController extends Controller
{
    use UploadsFiles;

    public function login_evaluate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Correo' => ['bail','required','email'],
            'Contrasenia' => ['required']
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $credentials = [
            'Correo' => $request->Correo,
            'Contrasenia' => $request->Contrasenia
        ];

        $login_medico = Http::post(api_url('/api/loginmedico'), $credentials);
        $confirm_medico = $login_medico->json();

        if ($jwt = $confirm_medico['access_token'] ?? null) {
            $jwt = Token::parse($jwt);
            $id = $jwt->getSubject();
            Jwt::storeToken($jwt, $confirm_medico['expires_in']);
            return redirect()->action('MedicoController@pacientesxmedico', [ 'id_medico' => $id ]);
        } else {
            $login_admin = Http::post(api_url('/api/loginadmin'), $credentials);
            $confirm_admin = $login_admin->json();

            if ($token = $confirm_admin['access_token'] ?? null) {
                Jwt::storeToken($token, $confirm_admin['expires_in']);
                return redirect()->action('AdminController@index_pacientes');
            }
        }
        //FIXME:
        return redirect()->back()->withErrors($confirm_admin['messages']);
    }

    public function pacientesxmedico()
    {
        $respuesta = Http::get(api_url('/api/listarpacientesxmedico/'));
        $pacientes = $respuesta->json();
        return view('pacientes', compact('pacientes'));
    }

    //PACIENTES
    public function index_pacientes()
    {
        $respuesta = Http::get(api_url('/api/listarpacientes'));
        $pacientes = $respuesta->json();
        return view('pacientes', compact('pacientes'));
    }

    public function asign_medico($id, Request $request)
    {
        $validatedData = $this->validate($request, [
            'medico_id' => ['required']
        ]);
        $response = Http::post(api_url('/api/paciente/asignar_medico/' . $id), [
            'medico_id' => $request->medico_id
        ]);
        $respuesta = Http::get(api_url('/api/listarpacientes'));
        $pacientes = $respuesta->json();
        return view('pacientes', compact('pacientes'));
    }

    public function asignar_medico($id)
    {
        $respuesta = Http::get(api_url('/api/paciente/buscarxid/' . $id));
        $paciente = $respuesta->json();
        $respuesta = Http::get(api_url('/api/listarmedicos'));
        $medicos = array_filter($respuesta->json(), function ($v) {
            return $v['Habilitado'] === 1;
        });


        return view('edit_paciente', compact('paciente', 'medicos'));
    }

    //PRAXIAS
    public function index_praxias()
    {
        $respuesta = Http::get(api_url('/api/listarpraxias'));
        $praxias = $respuesta->json();

        foreach ($praxias as $praxia) {
            $this->recoverFile($praxia['imagen'], $praxia['Nombre'], 'praxia', 'png');
            $this->recoverFile($praxia['Video'], $praxia['Nombre'], 'praxia', 'mp4');
        }

        return view('praxias', compact('praxias'));
    }

    public function create_praxias()
    {
        return view('create_praxias');
    }

    public function destroy_praxia($id)
    {
        $respuesta = Http::post(api_url('/api/praxia/borrar_praxia/' . $id));
        $respuesta = $respuesta->json();
        \Storage::disk('public')->delete("praxia_" . $respuesta['praxia']['Nombre'] . ".mp4");
        \Storage::disk('public')->delete("praxia_" . $respuesta['praxia']['Nombre'] . ".png");
        $respuesta2 = Http::get(api_url('/api/listarpraxias'));
        $praxias = $respuesta2->json();
        return view('praxias', compact('praxias'));
    }

    public function save_praxias(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Nombre' => ['required', 'between:1,25'],
            'Tipo' => ['required', 'between:1,25'],
            'Descripcion' => ['required', 'between:1,50'],
            'Video' => ['required_without:video_tmp', 'mimes:mp4'],
            'imagen' => ['required_without:imagen_tmp', 'mimes:png']
        ]);

        $this->storeTempFile('imagen', $request, $validator, 'praxia', 'Nombre', 'png');
        $this->storeTempFile('Video', $request, $validator, 'praxia', 'Nombre', 'mp4');

        $validator->validate();

        $video64 = $this->encodeTempFile('Video', $request);
        $imagen64 = $this->encodeTempFile('imagen', $request);

        $response = Http::post(api_url('/api/praxia/agregar_praxia'), [
                'Nombre' => $request->Nombre,
                'Tipo' => $request->Tipo,
                'Descripcion' => $request->Descripcion,
                'Video' => $video64,
                'imagen' => $imagen64
            ]
        );

        if (!$response->successful()) {
            throw ApiPostRequestException::fromResponse($response);
        }

        $this->finishTempFile('imagen', $request, 'praxia', $request->Nombre);
        $this->finishTempFile('Video', $request, 'praxia', $request->Nombre);

        return redirect()->back()->with('success', "La praxia \"{$request->Nombre}\" ha sido agregado satisfactoriamente");
    }

    public function editar_praxias($id)
    {
        $respuesta = Http::get(api_url('/api/praxia/buscarxid/' . $id));

        $praxia = $respuesta->json()[0];

        $name = $praxia['Nombre'];
        $prefix = 'praxia';

        $this->preloadTempFile('imagen', $name, $prefix, 'png');
        $this->preloadTempFile('Video', $name, $prefix, 'mp4');

        return view('edit_praxias', compact('praxia'));
    }

    public function update_praxias($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Nombre' => ['required', 'between:1,25'],
            'Tipo' => ['required', 'between:1,25'],
            'Descripcion' => ['required', 'between:1,50'],
            'Video' => ['nullable', 'mimes:mp4'],
            'imagen' => ['nullable', 'mimes:png']
        ]);

        $this->storeTempFile('imagen', $request, $validator, 'praxia', 'Nombre', 'png');
        $this->storeTempFile('Video', $request, $validator, 'praxia', 'Nombre', 'mp4');

        $validator->validate();

        $video64 = $this->encodeTempFile('Video', $request);
        $imagen64 = $this->encodeTempFile('imagen', $request);

        $response = Http::post(api_url('/api/praxia/actualizar_praxia/' . $id), [
                'Nombre' => $request->Nombre,
                'Tipo' => $request->Tipo,
                'Descripcion' => $request->Descripcion,
                'Video' => $video64,
                'imagen' => $imagen64
            ]
        );

        if (!$response->successful()) {
            throw ApiPostRequestException::fromResponse($response);
        }
        $this->finishTempFile('imagen', $request, 'praxia', $request->Nombre);
        $this->finishTempFile('Video', $request, 'praxia', $request->Nombre);


        return redirect()->back()->with('success', "La praxia \"{$request->Nombre}\" ha sido actualizada satisfactoriamente");
    }

    //VOCALES
    public function index_vocales()
    {
        $respuesta = Http::get(api_url('/api/listarvocales'));
        $vocales = $respuesta->json();
        return view('vocales', compact('vocales'));
    }

    public function destroy_vocal($id)
    {
        $respuesta = Http::post(api_url('/api/vocales/borrar_vocales/' . $id));
        $respuesta = $respuesta->json();
        \Storage::disk('public')->delete("vocal_" . $respuesta['vocales']['Nombre'] . ".png");
        $respuesta2 = Http::get(api_url('/api/listarvocales'));
        $vocales = $respuesta2->json();
        return view('vocales', compact('vocales'));
    }

    public function create_vocales()
    {
        return view('create_vocales');
    }

    public function save_vocales(Request $request)
    {
        $validatedData = $this->validate($request, [
            'Nombre' => ['alpha_space', 'required', 'between:1,25'],
            'Tipo' => ['required', 'between:1,25'],
            'Descripcion' => ['required', 'between:1,50'],
            'imagen' => ['required', 'mimes:png']
        ]);
        $imagen = file($request->imagen);
        \Storage::disk('public')->put("vocal_" . $request->Nombre . ".png", $imagen);

        $contents_imagen = file_get_contents(env('APP_URL') . '/web-kututis/storage/app/public/vocal_' . $request->Nombre . '.png');


        $imagen64 = base64_encode($contents_imagen);

        $response = Http::post(api_url('/api/vocales/agregar_vocales'), [
                'Nombre' => $request->Nombre,
                'Tipo' => $request->Tipo,
                'Descripcion' => $request->Descripcion,
                'imagen' => $imagen64
            ]
        );

        $respuesta = Http::get(api_url('/api/listarvocales'));
        $vocales = $respuesta->json();
        return view('vocales', compact('vocales'));
    }

    public function editar_vocales($id)
    {
        $respuesta = Http::get(api_url('/api/vocales/buscarxid/' . $id));
        $vocals = $respuesta->json();
        return view('edit_vocales', compact('vocals'));
    }

    public function update_vocales($id, Request $request)
    {

        $validatedData = $this->validate($request, [
            'Nombre' => ['alpha_space', 'required', 'between:1,25'],
            'Tipo' => ['required', 'between:1,25'],
            'Descripcion' => ['required', 'between:1,50'],
            'imagen' => ['required', 'mimes:png']
        ]);

        $imagen = file($request->imagen);
        \Storage::disk('public')->put("vocal_" . $request->Nombre . ".png", $imagen);

        $contents_imagen = file_get_contents(env('APP_URL') . '/web-kututis/storage/app/public/vocal_' . $request->Nombre . '.png');


        $imagen64 = base64_encode($contents_imagen);

        $response = Http::post(api_url('/api/vocales/actualizar_vocales/' . $id), [
                'Nombre' => $request->Nombre,
                'Tipo' => $request->Tipo,
                'Descripcion' => $request->Descripcion,
                'imagen' => $imagen64
            ]
        );

        $respuesta = Http::get(api_url('/api/listarvocales'));
        $vocales = $respuesta->json();
        return view('vocales', compact('vocales'));

    }

    //FONEMAS
    public function index_fonemas()
    {
        $respuesta = Http::get(api_url('/api/listarfonemas'));
        $fonemas = $respuesta->json();

        foreach ($fonemas as $fonema) {
            $this->recoverFile($fonema['imagen'], $fonema['Nombre'], 'fonema', 'png');
        }
        return view('consonan', compact('fonemas'));
    }

    public function create_fonemas()
    {
        return view('create_fonemas');
    }

    public function destroy_fonema($id)
    {
        $respuesta = Http::post(api_url('/api/fonema/borrar_fonemas/' . $id));
        $respuesta = $respuesta->json();
        \Storage::disk('public')->delete("fonema_" . $respuesta['fonema']['Nombre'] . ".png");
        $respuesta2 = Http::get(api_url('/api/listarfonemas'));
        $fonemas = $respuesta2->json();
        return view('consonan', compact('fonemas'));
    }

    public function save_fonemas(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Nombre' => ['alpha_space', 'required', 'between:1,25'],
            'Tipo' => ['required', 'between:1,25'],
            'Descripcion' => ['required', 'between:1,50'],
            'imagen' => ['required_without:imagen_tmp', 'mimes:png']
        ]);



        $this->storeTempFile('imagen', $request, $validator, 'fonema', 'Nombre', 'png');
        $validator->validate();

        $imagen64 = $this->encodeTempFile('imagen', $request);

        $response = Http::post(api_url('/api/fonema/agregar_fonema'), [
                'Nombre' => $request->Nombre,
                'Tipo' => $request->Tipo,
                'Descripcion' => $request->Descripcion,
                'imagen' => $imagen64
            ]
        );

        if (!$response->successful()) {
            throw ApiPostRequestException::fromResponse($response);
        }

        $this->finishTempFile('imagen', $request, 'fonema', $request->Nombre);
        return redirect()->back()->with('success', "El fonema \"{$request->Nombre}\" ha sido agregado satisfactoriamente");
    }

    public function editar_fonemas($id)
    {
        $respuesta = Http::get(api_url('/api/fonema/buscarxid/' . $id));
        $fonema = $respuesta->json();

        $this->preloadTempFile('imagen', $fonema[0]['Nombre'], 'fonema', 'png');
        return view('edit_consonan', compact('fonema'));
    }

    public function update_fonemas($id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'Nombre' => ['bail', 'alpha_space', 'required', 'between:1,25'],
            'Tipo' => ['bail', 'required', 'between:1,25'],
            'Descripcion' => ['bail', 'required', 'between:1,50'],
            'imagen' => ['bail', 'nullable', 'mimes:png']
        ]);

        $this->storeTempFile('imagen', $request, $validator, 'fonema', 'Nombre', 'png');
        $validator->validate();

        $imagen64 = $this->encodeTempFile('imagen', $request);

        $response = Http::post(api_url('/api/fonema/actualizar_fonemas/' . $id), [
                'Nombre' => $request->Nombre,
                'Tipo' => $request->Tipo,
                'Descripcion' => $request->Descripcion,
                'imagen' => $imagen64
            ]
        );

        if (!$response->successful()) {
            throw ApiPostRequestException::fromResponse($response);
        }

        $this->finishTempFile('imagen', $request, 'fonema', $request->Nombre);
        return redirect()->back()->with('success', "El fonema \"{$request->Nombre}\" ha sido actualizado satisfactoriamente");
    }

    //VOCABULARIO
    public function index_vocabulario()
    {
        $respuesta = Http::get(api_url('/api/vocabulario/listarvocabulario'));
        $vocabulario = $respuesta->json();

        $prefix = 'vocabulario';
        $ext = 'png';

        foreach ($vocabulario as $item) {
            $name = $item['Palabra'];
            $this->recoverFile($item['imagen'], $name, $prefix, $ext);
        }

        return view('vocabulario', compact('vocabulario'));
    }

    public function destroy_vocabulario($id)
    {
        $respuesta = Http::post(api_url('/api/vocabulario/borrar_vocabulario/' . $id));
        $respuesta = $respuesta->json();
        \Storage::disk('public')->delete("vocabulario_" . $respuesta['vocabulario']['Palabra'] . ".png");
        $respuesta2 = Http::get(api_url('/api/vocabulario/listarvocabulario'));
        $vocabulario = $respuesta2->json();
        return view('vocabulario', compact('vocabulario'));
    }

    public function create_vocabulario()
    {
        $respuesta = Http::get(api_url('/api/listarfonemas'));
        $fonemas = $respuesta->json();
        return view('create_vocabulario', compact('fonemas'));
    }

    public function save_vocabulario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Palabra' => ['bail', 'alpha_space', 'required', 'between:1,25'],
            'fonema' => ['required'],
            'imagen' => ['bail', 'required_without:imagen_tmp', 'mimes:png'],
        ]);

        $this->storeTempFile('imagen', $request, $validator, 'vocabulario', 'Palabra', 'png');
        //Verificar que no haya problemas con otros campos
        $validator->validate();

        $imagen64 = $this->encodeTempFile('imagen', $request);

        $response = Http::post(api_url('/api/vocabulario/agregar_vocabulario'), ['Palabra' => $request->Palabra,
                'fonema_id' => $request->fonema,
                'imagen' => $imagen64]
        );

        if (!$response->successful()) {
            throw ApiPostRequestException::fromResponse($response);
        }

        $this->finishTempFile('imagen', $request, 'vocabulario', $request->Palabra);

        return redirect()->back()->with('success', "La palabra \"{$request->Palabra}\" ha sido agregada satisfactoriamente");
    }

    public function editar_vocabulario($id)
    {
        $respuesta = Http::get(api_url('/api/vocabulario/buscarxid/' . $id));
        $vocabulario = $respuesta->json()[0];

        $this->preloadTempFile('imagen', $vocabulario['Palabra'], 'vocabulario', 'png');

        $respuesta2 = Http::get(api_url('/api/listarfonemas'));
        $fonemas = $respuesta2->json();
        return view('edit_vocabulario', compact('vocabulario', 'fonemas'));
    }

    public function update_vocabulario($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Palabra' => ['bail', 'alpha_space', 'required', 'between:1,25'],
            'fonema' => ['bail', 'required'],
            'imagen' => ['bail', 'nullable', 'mimes:png']
        ]);

        $this->storeTempFile('imagen', $request, $validator, 'vocabulario', 'Palabra', 'png');
        $validator->validate();

        $imagen64 = $this->encodeTempFile('imagen', $request);

        $response = Http::post(api_url('/api/vocabulario/actualizar_vocabulario/' . $id), [
                'Palabra' => $request->Palabra,
                'fonema_id' => $request->fonema,
                'imagen' => $imagen64
            ]
        );

        if (!$response->successful()) {
            throw ApiPostRequestException::fromResponse($response);
        }

        //TODO: guardar nombre antiguo para eliminar archivo huerfano
        $this->finishTempFile('imagen', $request, 'vocabulario', $request->Palabra);

        return redirect()->back()->with('success', "La palabra \"{$request->Palabra}\" ha sido actualizada satisfactoriamente");

    }

    //MEDICO
    public function index_medicos()
    {
        $respuesta = Http::get(api_url('/api/listarmedicos'));
        $medicos = $respuesta->json();
        return view('medicos', compact('medicos'));
    }

    public function create_medico()
    {

        return view('create_medicos');
    }

    public function save_medico(Request $request)
    {
        $validatedData = $this->validate($request, [
            'Nombre' => ['bail', 'alpha_space', 'required', 'between:1,25'],
            'Apellido' => ['bail', 'required', 'between:1,25'],
            'Correo' => ['bail', 'required', 'min:1', 'email'],
            'Contrasenia' => ['bail', 'required', 'min:8', 'max:16', 'valid_password'],
            'Habilitado' => ['required'],
            'Celular' => ['bail', 'required', 'min:9', 'max:9']
        ]);

        $response = Http::post(api_url('/api/registromedico'), [
                'Nombre' => $request->Nombre,
                'Apellido' => $request->Apellido,
                'Correo' => $request->Correo,
                'Contrasenia' => $request->Contrasenia,
                'Habilitado' => $request->Habilitado,
                'Celular' => $request->Celular
            ]
        );

        if (!$response->successful()) {
            throw ApiPostRequestException::fromResponse($response);
        }
        return redirect()->back()->with('success', "El médico ha sido agregado satisfactoriamente");
    }

    public function editar_medico($id)
    {
        $respuesta = Http::get(api_url('/api/medico/buscarxid/' . $id));
        $medico = $respuesta->json()[0];
        return view('edit_medico', compact('medico'));
    }

    public function update_medico($id, Request $request)
    {
        $validatedData = $this->validate($request, [
            'Nombre' => ['bail', 'alpha_space', 'required', 'between:1,25'],
            'Apellido' => ['bail', 'required', 'between:1,25'],
            'Correo' => ['bail', 'required', 'min:1', 'email'],
            'Contrasenia' => ['bail', 'required', 'min:8', 'max:16', 'valid_password'],
            'Habilitado' => ['required'],
            'Celular' => ['bail', 'required', 'min:9', 'max:9']
        ]);

        $response = Http::post(api_url('/api/medico/actualizar_medico/' . $id), [
                'Nombre' => $request->Nombre,
                'Apellido' => $request->Apellido,
                'Correo' => $request->Correo,
                'Contrasenia' => $request->Contrasenia,
                'Habilitado' => $request->Habilitado,
                'Celular' => $request->Celular,
            ]
        );

        if (!$response->successful()) {
            throw ApiPostRequestException::fromResponse($response);
        }
        return redirect()->back()->with('success', "El médico ha sido actualizado satisfactoriamente");
    }

    public function habilitar_medico($id)
    {
        $post = Http::post(api_url('/api/habilitarmedico/' . $id));
        $respuesta = Http::get(api_url('/api/listarmedicos'));
        $medicos = $respuesta->json();
        return view('medicos', compact('medicos'));
    }

    public function deshabilitar_medico($id)
    {
        $post = Http::post(api_url('/api/deshabilitarmedico/' . $id));
        $respuesta = Http::get(api_url('/api/listarmedicos'));
        $medicos = $respuesta->json();
        return view('medicos', compact('medicos'));

    }

}
