<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtAuthenticate;
use App\Helpers\Jwt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*================================== LOGIN ==================================*/

Route::get('/', function () {
    $jwt = Jwt::getToken();
    if ($jwt->hasRole('admin'))
            return redirect()->action('AdminController@index_pacientes');
    if ($jwt->hasRole('medico'))
            return redirect()->action('MedicoController@pacientesxmedico', [ 'id_medico' => $jwt->getSubject() ]);
    return redirect('login');
})->middleware(JwtAuthenticate::class);

Route::post('/login_evaluate', array('as' => 'login_evaluate', 'uses' => 'AdminController@login_evaluate'));
Route::get('/logout', function () {
    Jwt::clearToken();
    return redirect()->back();
});

Route::get('/login', function () {
    return view('login');
});

/*============================== ADMINISTRADOR ==============================*/
Route::prefix('admin')->middleware(['jtw', 'role:admin'])->group(function () {

    /** PACIENTES */
    //vistas
    Route::get('pacientes', 'AdminController@index_pacientes');
    Route::get('asignar_medico/{id}',array('as' => 'asignar_medico', 'uses' => 'AdminController@asignar_medico'));
    //
    Route::post('asign_medico/{id}', array('as' => 'asign_medico', 'uses' => 'AdminController@asign_medico'));

    /** MEDICOS */
    //vistas
    Route::get('medicos', 'AdminController@index_medicos');
    Route::get('crear_medicos', 'AdminController@create_medico');
    Route::get('editar_medico/{id}',  array('as' => 'editar_medico', 'uses' => 'AdminController@editar_medico'));
    //
    Route::post('save_medico', array('as' => 'save_medico', 'uses' => 'AdminController@save_medico'));
    Route::post('update_medico/{id}', array('as' => 'update_medico', 'uses' => 'AdminController@update_medico'));
    Route::get('habilitar_medico/{id}', 'AdminController@habilitar_medico');
    Route::get('deshabilitar_medico/{id}', 'AdminController@deshabilitar_medico');

    /** PRAXIAS */
    //vistas
    Route::get('praxias', 'AdminController@index_praxias');
    Route::get('crear_praxias', 'AdminController@create_praxias');
    Route::get('editar_praxias/{id}',  array('as' => 'editar_praxias', 'uses' => 'AdminController@editar_praxias'));
    //
    Route::post('save_praxias', array('as' => 'save_praxias', 'uses' => 'AdminController@save_praxias'));
    Route::post('update_praxias/{id}', array('as' => 'update_praxias', 'uses' => 'AdminController@update_praxias'));
    Route::get('destroy_praxia/{id}','AdminController@destroy_praxia');

    /**FONEMAS*/
    //vistas
    Route::get('consonantes', 'AdminController@index_fonemas');
    Route::get('crear_fonemas', 'AdminController@create_fonemas');
    Route::get('editar_fonemas/{id}',  array('as' => 'editar_fonemas', 'uses' => 'AdminController@editar_fonemas'));
    //
    Route::post('save_fonemas', array('as' => 'save_fonemas', 'uses' => 'AdminController@save_fonemas'));
    Route::post('update_fonemas/{id}', array('as' => 'update_fonemas', 'uses' => 'AdminController@update_fonemas'));
    Route::get('destroy_fonema/{id}','AdminController@destroy_fonema');

    /** VOCABULARIO */
    //vistas
    Route::get('vocabulario', 'AdminController@index_vocabulario');
    Route::get('crear_vocabulario', 'AdminController@create_vocabulario');
    Route::get('editar_vocabulario/{id}',  array('as' => 'editar_vocabulario', 'uses' => 'AdminController@editar_vocabulario'));
    //
    Route::post('save_vocabulario', array('as' => 'save_vocabulario', 'uses' => 'AdminController@save_vocabulario'));
    Route::post('update_vocabulario/{id}', array('as' => 'update_vocabulario', 'uses' => 'AdminController@update_vocabulario'));
    Route::get('destroy_vocabulario/{id}','AdminController@destroy_vocabulario');

});

/*================================= MEDICO ==================================*/

Route::prefix('medico')->middleware(['jtw', 'role:medico', 'id'])->group(function () {

    /** DATOS */
    Route::get('edit_contrasenia_medico/{id_medico}', 'MedicoController@editar_medico');
    Route::post('update_contrasenia_medico/{id_medico}', array('as' => 'update_contrasenia_medico', 'uses' => 'MedicoController@update_contrasenia_medico'));

    /** LISTA PACIENTES */
    Route::get('pacientesxmedico/{id_medico}', 'MedicoController@pacientesxmedico')->name('medico.pacientes.index');

    /** ESTADO SESIONES */
    Route::get('veravance_praxias/{id_medico}/{id_user}', 'MedicoController@veravance_praxia')->name('medico.pacientes.praxias.index');
    Route::get('veravance_vocabulario/{id_medico}/{id_user}', 'MedicoController@veravance_vocabulario')->name('medico.pacientes.vocabulario.index');
    Route::get('veravance_fonema/{id_medico}/{id_user}', 'MedicoController@veravance_fonema')->name('medico.pacientes.fonemas.index');
    //Alternar estado
    Route::get('sesion_praaxias/alternar_estado/{id_medico}/{id_user}/{id_sesion_praxia}/{completado}', 'MedicoController@alternar_estado_praxia')->name('medico.pacientes.praxias.estado');
    Route::get('sesion_fonemas/alternar_estado/{id_medico}/{id_user}/{id_sesion_fonema}/{completado}', 'MedicoController@alternar_estado_fonema')->name('medico.pacientes.fonemas.estado');
    Route::get('sesion_vocabulario/alternar_estado/{id_medico}/{id_user}/{id_sesion_vocabulario}/{completado}', 'MedicoController@alternar_estado_vocabulario')->name('medico.pacientes.vocabulario.estado');


    /** CREAR SESION */
    Route::get('create_sesion_praxias/{id_medico}/{id_user}','MedicoController@create_sesion_praxias')->name('medico.pacientes.praxias.create');
    Route::get('create_sesion_fonemas/{id_medico}/{id_user}','MedicoController@create_sesion_fonemas')->name('medico.pacientes.fonemas.create');
    Route::get('create_sesion_vocabuario/{id_medico}/{id_user}','MedicoController@create_sesion_vocabuario')->name('medico.pacientes.vocabulario.create');
    //
    Route::post('crear_sesion_praxias/{id_medico}', array('as' => 'crear_sesion_praxias', 'uses' => 'MedicoController@crear_sesion_praxias'));
    Route::post('crear_sesion_fonemas/{id_medico}', array('as' => 'crear_sesion_fonemas', 'uses' => 'MedicoController@crear_sesion_fonemas'));
    Route::post('crear_sesion_vocabulario/{id_medico}', array('as' => 'crear_sesion_vocabulario', 'uses' => 'MedicoController@crear_sesion_vocabulario'));

    /** INTENTOS EN UNA SESION */
    Route::get('lista_archivos_praxias/{id_medico}/{id_user}/{id_sesion_praxia}', 'MedicoController@lista_archivos_praxias')->name('medico.pacientes.praxias.archivos.index');
    Route::get('lista_archivos_fonemas/{id_medico}/{id_user}/{id_sesion_fonema}', 'MedicoController@lista_archivos_fonemas')->name('medico.pacientes.fonemas.archivos.index');

    /** ARCHIVOS ENVIADOS */
    Route::get('ver_archivos_praxias/{id_medico}/{id_user}/{id_sesion_praxia}/{id_archivo_praxia}', 'MedicoController@ver_archivos_praxias')->name('medico.pacientes.praxias.archivos.show');
    Route::get('ver_archivos_fonemas/{id_medico}/{id_user}/{id_sesion_fonema}/{id_archivo_fonema}', 'MedicoController@ver_archivos_fonemas')->name('medico.pacientes.fonemas.archivos.show');
    //Evaluar archivos
    Route::get('evaluar_archivo_sesion_praxia/{id_archivo_sesion_praxia}/{id_sesion_praxia}/{Aprobado}/{id_medico}', 'MedicoController@evaluar_archivo_sesion_praxia')->name('medico.pacientes.praxias.archivos.estado');
    Route::get('evaluar_archivo_sesion_fonema/{id_archivo_sesion_fonema}/{id_sesion_fonema}/{Aprobado}/{id_medico}', 'MedicoController@evaluar_archivo_sesion_fonema')->name('medico.pacientes.praxias.archivos.estado');


});


Route::get('admin/vocales', 'AdminController@index_vocales');
