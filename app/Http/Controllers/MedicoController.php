<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiPostRequestException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Http;

class MedicoController extends Controller
{
    public function pacientesxmedico($id)
    {
        $respuesta = Http::get(api_url('/api/listarpacientesxmedico/' . $id));
        $pacientes = $respuesta->json();
        if (!$pacientes) {
            //FIXME: extract from jwt
            $medico = Http::get(api_url('/api/medico/buscarxid/'.$id))->json()[0];
        } else {
            $medico = $pacientes[0]['medico'];
        }
        $id_medico = $id;
        return view('/pacientes_de_medico', compact('pacientes', 'id_medico', 'medico'));
    }

    public function verprogresogeneral()//Se suman las praxias, fonemas y vocabulario aprobado sobre el total
    {
        /////
    }

    //SESION PRAXIAS
    public function veravance_praxia($id_medico, $id_user)
    {
        $respuesta = Http::get(api_url('/api/listar_sesionpraxiasxusuario/' . $id_user));
        $sesion_praxias = $respuesta->json();
        $paciente = $sesion_praxias[0]['paciente'] ?? null;
        if (!$paciente) {
            $paciente = Http::get(api_url('/api/paciente/buscarxid/' . $id_user))->json()[0];
        }
        return view('/avance_praxia', compact('sesion_praxias', 'id_medico', 'id_user', 'paciente'));
    }

    public function create_sesion_praxias($id_medico, $id_user)
    {
        $respuesta = Http::get(api_url('/api/listarpraxias'));
        $praxias = $respuesta->json();
        return view('create_sesion_praxias', compact('praxias', 'id_medico', 'id_user'));
    }

    public function crear_sesion_praxias($id_medico, Request $requesta)
    {
        $validatedData = $this->validate($requesta, [
            'Repeticiones' => ['bail','numeric', 'required', 'min:1'],
            'praxia' => ['required']
        ]);
        $response = Http::post(api_url('/api/registrosesion_praxias'), [
                'Repeticiones' => $requesta->Repeticiones,
                'praxias_id' => $requesta->praxia,
                'paciente_id' => $requesta->paciente_id,
            ]
        );

        if (!$response->successful()) {
            throw ApiPostRequestException::fromResponse($response);
        }
        return redirect()->back()->with('success', "La praxia ha sido asignada satisfactoriamente");
    }

    public function alternar_estado_praxia($id_medico, $id_user, $id_sesion_praxia, $completado)
    {
        $value = $completado === '1' ? 0 : 1;
        $response = Http::post(api_url('/api/sesion_praxia/' . $id_sesion_praxia . '/cambiar_estado'), [
            'completado' => "{$value}"
        ]);

        return redirect()->action('MedicoController@veravance_praxia', compact('id_medico', 'id_user'));

    }

    public function lista_archivos_praxias($id_medico, $id_user, $id_praxia ,$id)
    {
        $respuesta = Http::get(api_url('/api/archivos_sesion_praxia/buscararchivosxsesionpraxiaid/' . $id));
        $archivos_sesion_praxias = $respuesta->json();
        $id_sesion_praxia = $id;

        $praxia = Http::get(api_url('/api/praxia/buscarxid/' . $id_praxia))->json()[0];
        $paciente = Http::get(api_url('/api/paciente/buscarxid/' . $id_user))->json()[0];

        return view('lista_archivos_praxias', compact('archivos_sesion_praxias', 'id_medico', 'id_user', 'id_sesion_praxia', 'praxia', 'paciente'));

    }

    public function evaluar_archivo_sesion_praxia($id_archivo_sesion_praxia, $id_sesion_praxia, $Aprobado, $id)
    {
        $response = Http::post(api_url('/api/archivos_sesion_praxia/evaluar_archivo_sesion_praxia/' . $id_archivo_sesion_praxia . '/' . $id_sesion_praxia . '/' . $Aprobado));

        if (!$response->successful()) {
            throw ApiPostRequestException::fromResponse($response);
        }
        return redirect()->back()->with('success', "La praxia ha sido asignada satisfactoriamente");
    }

    public function ver_archivos_praxias($id_medico, $id_user, $id_praxia, $id_sesion_praxia, $id)
    {
        $respuesta = Http::get(api_url('/api/archivos_sesion_praxia/buscarxid/' . $id));
        $archivos_sesion_praxias = $respuesta->json()[0];
        // $video64 = base64_decode($archivos_sesion_praxias->archivo);
        return view('ver_archivos_praxias', compact('archivos_sesion_praxias', 'id_medico', 'id_user', 'id_praxia' ,'id_sesion_praxia'));
    }

    //SESION FONEMAS
    public function veravance_fonema($id_medico, $id_user)
    {
        $respuesta = Http::get(api_url('/api/listar_sesionfonemasxusuario/' . $id_user));
        $sesion_fonemas = $respuesta->json();
        $paciente = $sesion_fonemas[0]['paciente'] ?? null;
        if (!$paciente) {
            $paciente = Http::get(api_url('/api/paciente/buscarxid/' . $id_user))->json()[0];
        }

        return view('/avance_fonema', compact('sesion_fonemas', 'id_medico', 'id_user', 'paciente'));
    }

    public function create_sesion_fonemas($id_medico, $id_user)
    {
        $respuesta = Http::get(api_url('/api/listarfonemas'));
        $fonemas = $respuesta->json();

        return view('create_sesion_fonemas', compact('fonemas', 'id_medico', 'id_user'));
    }

    public function crear_sesion_fonemas($id_medico, Request $requesta)
    {
        $validatedData = $this->validate($requesta, [
            'Repeticiones' => ['bail','numeric', 'required', 'min:1'],
            'fonema' => ['required']
        ]);
        $response = Http::post(api_url('/api/registrosesion_fonemas'), [
                'Repeticiones' => $requesta->Repeticiones,
                'fonema_id' => $requesta->fonema,
                'paciente_id' => $requesta->paciente_id,
            ]
        );

        if (!$response->successful()) {
            throw ApiPostRequestException::fromResponse($response);
        }
        return redirect()->back()->with('success', "El fonema ha sido asignado satisfactoriamente");

    }

    public function alternar_estado_fonema($id_medico, $id_user, $id_sesion_fonema, $completado)
    {
        $value = $completado === '1' ? 0 : 1;
        $response = Http::post(api_url('/api/sesion_fonema/' . $id_sesion_fonema . '/cambiar_estado'), [
            'completado' => "{$value}"
        ]);

        return redirect()->action('MedicoController@veravance_fonema', compact('id_medico', 'id_user'));

    }

    //lista_archivos_fonemas
    public function lista_archivos_fonemas($id_medico, $id_user, $id_fonema, $id)
    {
        $respuesta = Http::get(api_url('/api/archivos_sesion_fonema/buscararchivosxsesionfonemaid/' . $id));
        $archivos_sesion_fonemas = $respuesta->json();
        // $video64 = base64_decode($archivos_sesion_praxias->archivo);

        $fonema = Http::get(api_url('/api/fonema/buscarxid/' . $id_fonema))->json()[0];
        $paciente = Http::get(api_url('/api/paciente/buscarxid/' . $id_user))->json()[0];

        $id_sesion_fonema = $id;

        return view('lista_archivos_fonemas', compact('archivos_sesion_fonemas', 'id_medico', 'id_user', 'id_sesion_fonema', 'fonema', 'paciente'));

    }

    public function evaluar_archivo_sesion_fonema($id_archivo_sesion_fonema, $id_sesion_fonema, $Aprobado, $id)
    {
        $response = Http::post(api_url('/api/archivos_sesion_fonema/evaluar_archivo_sesion_fonema/' . $id_archivo_sesion_fonema . '/' . $id_sesion_fonema . '/' . $Aprobado));

        if (!$response->successful()) {
            throw ApiPostRequestException::fromResponse($response);
        }
        return redirect()->back()->with('success', "La praxia ha sido asignada satisfactoriamente");
    }

    public function ver_archivos_fonemas($id_medico, $id_user, $id_fonema, $id_sesion_fonema, $id)
    {
        $respuesta = Http::get(api_url('/api/archivos_sesion_fonema/buscarxid/' . $id));
        $archivos_sesion_fonemas = $respuesta->json();
        // $video64 = base64_decode($archivos_sesion_praxias->archivo);
        return view('ver_archivos_fonemas', compact('archivos_sesion_fonemas', 'id_medico', 'id_user', 'id_fonema' , 'id_sesion_fonema'));
    }

    //SESION VOCABULARIO
    public function veravance_vocabulario($id_medico, $id_user)
    {
        $respuesta = Http::get(api_url('/api/sesion_vocabulario/listar_sesionvocabularioxusuario/' . $id_user));
        $sesion_vocabularios = $respuesta->json();

        $paciente = $sesion_vocabularios[0]['paciente'] ?? null;
        if (!$paciente) {
            $paciente = Http::get(api_url('/api/paciente/buscarxid/' . $id_user))->json()[0];
        }
        return view('/avance_vocabulario', compact('sesion_vocabularios', 'id_medico', 'id_user', 'paciente'));

    }

    public function create_sesion_vocabuario($id_medico, $id_user)
    {
        $respuesta = Http::get(api_url('/api/vocabulario/listarvocabulario'));
        $vocabularios = $respuesta->json();

        return view('create_sesion_vocabulario', compact('vocabularios', 'id_medico', 'id_user'));
    }//registrosesion_vocabulario

    public function crear_sesion_vocabulario($id_medico, Request $requesta)
    {
        $validatedData = $this->validate($requesta, [
            'Repeticiones' => ['bail', 'numeric', 'required', 'min:1'],
            'vocabulario' => ['required']
        ]);
        $response = Http::post(api_url('/api/registrosesion_vocabulario'), [
                'Repeticiones' => $requesta->Repeticiones,
                'vocabulario_id' => $requesta->vocabulario,
                'paciente_id' => $requesta->paciente_id,
            ]
        );

        if (!$response->successful()) {
            throw ApiPostRequestException::fromResponse($response);
        }
        return redirect()->back()->with('success', "La palabra ha sido asignada satisfactoriamente");
    }

    public function alternar_estado_vocabulario($id_medico, $id_user, $id_sesion_vocabulario, $completado)
    {
        $value = $completado === '1' ? 0 : 1;
        $response = Http::post(api_url('/api/sesion_vocabulario/' . $id_sesion_vocabulario . '/cambiar_estado'), [
            'completado' => "{$value}"
        ]);

        return redirect()->action('MedicoController@veravance_vocabulario', compact('id_medico', 'id_user'));

    }

    //DATOS
    public function editar_medico($id)
    {
        $respuesta = Http::get(api_url('/api/medico/buscarxid/' . $id));
        $medico = $respuesta->json();
        $id_medico = $id;
        return view('edit_contrasenia_medico', compact('medico', 'id_medico'));
    }

    public function update_contrasenia_medico($id, Request $requesta)
    {
        $validatedData = $this->validate($requesta, [
            'Contraseña' => ['bail', 'required', 'between:8,16', 'confirmed', 'valid_password'],
        ]);

        $response = Http::post(api_url('/api/medico/actualizar_contrasenia_medico/' . $id), [
            'Contrasenia' => $requesta->Contraseña]);

        if (!$response->successful()) {
            throw ApiPostRequestException::fromResponse($response);
        }
        return redirect()->back()->with('success', 'La constraseña ha sido actualizada satisfactoriamente');
    }
}
