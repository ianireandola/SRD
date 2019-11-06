<?php

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

use App\Http\Controllers\UserAdminController;

Route::get('/', function () {
    return view('principal');
});

Route::get('/historial', 'HistorialController@index')->name('historial');

Auth::routes(['reset' => false]);

Route::get('/home', 'HomeController@index')->name('registroHoras');


Route::delete('/letras/{letra_id}/{user_id}', 'LetraController@destroy');
Route::resource('/letras', 'LetraController');
Route::resource('/letras_todo', 'LetrasTodoController');
Route::match(['get', 'head'], '/srd_proyectos/showAccion2/{accion2_id}', 'SRDProyectoController@showAccion2');
Route::resource('/proyectos', 'ProyectoController');
Route::match(['get', 'head'], '/srd_letras/showLetra/{letra_id}', 'SRDLetraController@showLetra');
Route::resource('/srd_letras', 'SRDLetraController');
Route::resource('/secciones', 'SeccionController');
Route::resource('/srd_proyectos', 'SRDProyectoController');
Route::resource('/acciones2', 'Accion2Controller');
Route::resource('/elementos', 'ElementoController');
Route::delete('/proyecto_user/{proyecto_id}/{user_id}', 'ProyectoUserController@destroy');
Route::resource('/proyecto_user', 'ProyectoUserController');


Route::get('/test/datepicker', function () {
    return view('datepicker');
});


Route::prefix('admin')->group(function()
{
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::resource('/areas', 'AreaController');
    Route::match(['get', 'head'], '/secciones/showTrabajan/{seccion_id}', 'SeccionAdminController@showTrabajan');
    Route::resource('/secciones', 'SeccionAdminController');
    Route::resource('/plantas', 'PlantaController');
    Route::resource('/categorias', 'CategoriaController');
    Route::match(['put', 'patch'], '/usuarios/fijoeventualUpdate/{resource}', 'UserAdminController@fijoeventualUpdate')->name('usuarios.fijoeventualUpdate');
    Route::resource('/fijos_eventuales', 'FijoEventualController');  
    Route::resource('/dedicaciones', 'DedicacionController');
    Route::resource('/tipos_proyecto', 'TipoProyectoController');
    Route::resource('/naciones', 'NacionController');
    Route::resource('/fases', 'FaseController');
    Route::resource('/accion2s', 'Accion2AdminController');
    Route::resource('/admins', 'AdminAdminController');
    Route::match(['put', 'patch'], '/usuarios/categoriaUpdate/{resource}', 'UserAdminController@categoriaUpdate')->name('usuarios.categoriaUpdate');
    Route::get('/usuarios/{usuario_id}/buscarFE', 'UserAdminController@FEcoincidentes');
    Route::match(['get', 'head'], '/usuarios/showSeccion/{seccion_id}', 'UserAdminController@showSeccion');
    Route::resource('/usuarios', 'UserAdminController');
    Route::resource('/proyectos', 'ProyectoAdminController');
    Route::match(['put', 'patch'], '/proyectospadre/nacionUpdate/{resource}', 'ProyectoPadreController@nacionUpdate')->name('proyectospadre.nacionUpdate');
    Route::match(['put', 'patch'], '/proyectospadre/tipoProyectoUpdate/{resource}', 'ProyectoPadreController@tipoProyectoUpdate')->name('proyectospadre.tipoProyectoUpdate');
    Route::resource('/proyectospadre', 'ProyectoPadreController');
    Route::resource('/hitos', 'HitoController');
    Route::resource('/letras', 'LetraAdminController');
});
