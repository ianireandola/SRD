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
Route::match(['get', 'head'], '/srd_proyectos/showElemento/{elemento_id}', 'SRDProyectoController@showElemento');
Route::match(['get', 'head'], '/srd_proyectos/showUsuario/{user_id}', 'SRDProyectoController@showUsuario');
Route::resource('/proyectos', 'ProyectoController');
Route::match(['get', 'head'], '/srd_letras/showLetra/{letra_id}', 'SRDLetraController@showLetra');
Route::match(['get', 'head'], '/srd_letras/showUsuario/{user_id}', 'SRDLetraController@showUsuario');
Route::resource('/srd_letras', 'SRDLetraController');
Route::resource('/secciones', 'SeccionController');
Route::match(['get', 'head'], '/srd_proyectos/showProyecto/{proyecto_id}', 'SRDProyectoController@showProyecto');
Route::resource('/srd_proyectos', 'SRDProyectoController');
Route::resource('/acciones2', 'Accion2Controller');
Route::resource('/elementos', 'ElementoController');
Route::delete('/proyecto_user/{proyecto_id}/{user_id}', 'ProyectoUserController@destroy');
Route::resource('/proyecto_user', 'ProyectoUserController');

Route::prefix('admin')->group(function()
{
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::resource('/areas', 'AreaController');
    Route::match(['get', 'head'], '/secciones/showTrabajan/{seccion_id}', 'SeccionAdminController@showTrabajan');
    Route::match(['get', 'head'], '/secciones/showSeccion/{seccion_id}', 'SeccionAdminController@showSeccion');
    Route::resource('/secciones', 'SeccionAdminController');
    Route::resource('/plantas', 'PlantaController');
    Route::resource('/categorias', 'CategoriaController');
    Route::match(['put', 'patch'], '/usuarios/fijoeventualUpdate/{resource}', 'UserAdminController@fijoeventualUpdate');
    Route::resource('/fijos_eventuales', 'FijoEventualController');  
    Route::resource('/dedicaciones', 'DedicacionController');
    Route::resource('/tipos_proyecto', 'TipoProyectoController');
    Route::resource('/naciones', 'NacionController');
    Route::resource('/fases', 'FaseController');
    Route::match(['put', 'patch'], '/accions2/updateProyecto/{resource}', 'Accion2AdminController@updateProyecto');
    Route::match(['get', 'head'], '/accions2/showProyecto/{resource}', 'Accion2AdminController@showProyecto');
    Route::resource('accion2s', 'Accion2AdminController');
    Route::resource('/admins', 'AdminAdminController');
    Route::match(['put', 'patch'], '/usuarios/categoriaUpdate/{resource}', 'UserAdminController@categoriaUpdate');
    Route::get('/usuarios/{usuario_id}/buscarFE', 'UserAdminController@FEcoincidentes');
    Route::match(['get', 'head'], '/usuarios/showSeccion/{seccion_id}', 'UserAdminController@showSeccion');
    Route::resource('/usuarios', 'UserAdminController');
    Route::match(['get', 'head'], '/proyectos/showProyectoPadre/{proyectoPadre_id}', 'ProyectoAdminController@showProyectoPadre');
    Route::match(['put', 'patch'], '/proyectos/proyectoPadreUpdate/{proyecto_id}', 'ProyectoAdminController@proyectoPadreUpdate');
    Route::resource('/proyectos', 'ProyectoAdminController');
    Route::match(['put', 'patch'], '/proyectospadre/nacionUpdate/{resource}', 'ProyectoPadreController@nacionUpdate');
    Route::match(['put', 'patch'], '/proyectospadre/tipoProyectoUpdate/{resource}', 'ProyectoPadreController@tipoProyectoUpdate');
    Route::match(['get', 'head'], '/proyectospadre/showAvance/{proyectoPadre_id}', 'ProyectoPadreController@showAvance');
    Route::resource('/proyectospadre', 'ProyectoPadreController');
    Route::resource('/hitos', 'HitoController');
    Route::resource('/letras', 'LetraAdminController');
    Route::match(['put', 'patch'], '/elementos/tipoElementoUpdate/{resource}', 'ElementoAdminController@tipoElementoUpdate');
    Route::match(['put', 'patch'], '/elementos/proyectoUpdate/{resource}', 'ElementoAdminController@proyectoUpdate');
    Route::match(['get', 'head'], '/elementos/showProyecto/{resource}', 'ElementoAdminController@showProyecto');
    Route::resource('/elementos', 'ElementoAdminController');
    Route::resource('/tipo_elementos', 'TipoElementoAdminController');
    Route::resource('/avance_proyectos', 'AvanceProyectoController');
    Route::resource('/trabajan', 'TrabajanController');
    Route::resource('/composicion', 'ComposicionController');
    Route::match(['get', 'head'], '/srd/createLetras', 'SRDAdminController@createletras');
    Route::match(['get', 'head'], '/srd/createProyectos', 'SRDAdminController@createProyectos');
    Route::match(['get', 'head'], '/srd/showLetras/{fecha}', 'SRDAdminController@showLetras');
    Route::get('/srd/descarga', 'SRDAdminController@descarga');
    Route::resource('/srd', 'SRDAdminController');
    /*Route::get('/descarga', function () {
        return (new SRDExport)->download('horasRegistradas.xlsx');
    });*/
});
