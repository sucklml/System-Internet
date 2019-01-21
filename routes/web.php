<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*-------------------Pagina Principal----------------------*/
//Route::get('/', 'HomeController@sarray');

Route::resource('/','HomeController');
Route::resource('/logeo','HomeController');
Route::get('/salir','HomeController@salir');

/*---------------------------------------------------------*/
/*------------Modulo Realizar Contrato----------------------*/
/*1)Pagina Cliente*/
Route::get('/pagCliente', 'ClienteController@index');
Route::post('/pagCliente/crearUsuario', 'ClienteController@f_guardar');
/*1)Pagina Proveedor*/
Route::get('/pagProveedor', 'ProveedorController@index');
Route::post('/pagProveedor/crearProveedor', 'ProveedorController@create');
Route::get('/pagProveedor/Eliminar/{idProveedor}', 'ProveedorController@destroy');
/*3)Pagina Contrato*/
Route::get('/pagContrato/{v}', 'ContratoController@index');
/*----------------------------------------------------------*/

/*------------ Modulo Crear Puntos de Acceso ---------------*/
Route::get('/pagPuntosAccesos/{v}','PuntosAccesoController@index');
/*----------------------------------------------------------*/

/*------------ Modulo Asignar Area Contrato ----------------*/
Route::post('/pagContrato/asignarAreaContrato', 'AsignarAreaContratoController@index');
Route::post('/pagPuntosAccesos/fls_listarSubArea', 'AsignarAreaContratoController@fls_listarSubArea');
Route::post('/pagContrato/asignarAreaContrato/Guardar', 'AsignarAreaContratoController@guardar');
/*Si dentran por  metodo get redirecionar*/
Route::get('/pagContrato/asignarAreaContrato', 'AsignarAreaContratoController@salir');
/*----------------------------------------------------------*/


/*------------ Modulo Consultar Consumo Solicitado ---------------------------*/
Route::get('/pagConsumoSolicitado/{v}', 'ReporteSolicitadoController@index');
Route::get('/pagReporte/{idContrato}/{fechaDesde?}/{fechaHasta?}', 'ReporteSolicitadoController@view_Reporte');
Route::post('//pagConsumoSolicitado/Search', 'ReporteSolicitadoController@Search');
Route::get('/pagConsumoSolicitado/VerGenerado/{idDocumentos}/{tipo}', 'ReporteSolicitadoController@view_ReporteGenerado');
Route::get('/pagConsumoSolicitado/EstadoDoc/{Estado}', 'ReporteSolicitadoController@f_EstadoDoc');
Route::get('/pagConsumoSolicitado/AceptarDoc/{idDocumentos}', 'ReporteSolicitadoController@f_aceptarDoc');
Route::get('/pagConsumoSolicitado/EliminarDoc/{idDocumentos}', 'ReporteSolicitadoController@f_eliminarDoc');
Route::get('/pagConsumoSolicitado/ExtornarDoc/{idDocumentos}', 'ReporteSolicitadoController@f_extornarDoc');

Route::get('/pagConsumoReal/{v}', 'ReporteRealController@index');
Route::post('/pagConsumoReal/lstareas', 'ReporteRealController@fls_areas');
Route::get('/pagReporteReal/{idMicrotik}/{fechaDesde?}/{fechaHasta?}', 'ReporteRealController@view_Reporte');

/*----------------------------------------------------------*/




///////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*********************************************AJAX***********************************************************/
//----------------------------Entidad

Route::post('//pagClientes/Eliminar', 'ClienteController@eliminar');
//--------------------------Consultar consumo solicitado-------------------------------------------
Route::post('/pagConsumoSolicitado/subirPdf', 'ReporteSolicitadoController@subirPdf');
Route::post('/pagConsumoSolicitado/guardarPdf', 'ReporteSolicitadoController@fint_guardarPdf');
//Route::post('/pagConsumoSolicitado/lstDocumentos', 'ReporteSolicitadoController@flst_Documentos');


//---------------------------Puntos de Acceso -----------------------------------------------------
Route::post('/pagPuntosAccesos/CrearArea', 'PuntosAccesoController@fint_guardarArea');
Route::post('/pagPuntosAccesos/CrearConsumo', 'PuntosAccesoController@fbol_guardarConsumo');
Route::post('/pagPuntosAccesos/obtenerArea', 'PuntosAccesoController@fobj_obtenerArea');
Route::post('/pagPuntosAccesos/EliminarArea', 'PuntosAccesoController@fbol_Eliminar');
Route::post('/pagPuntosAccesos/GenerarReporte', 'ReporteSolicitadoController@fbol_guardarView');
//---------------------------Contrato  -----------------------------------------------------
Route::post('/pagContrato/CrearContrato', 'ContratoController@fbol_guardarContrato');
Route::post('/pagContrato/Eliminar', 'ContratoController@f_eliminar');


/*********************************************AJAX***********************************************************/


Route::auth();

Route::get('/home', 'HomeController@home');
//---------------------Mikrotik-------------------------------------------
Route::post('/getdata/{interface}', 'HomeController@GetDataMikrotik');
//------------------------------------------------------------------------

Route::post('/MKTdata/{fecha}', 'MikrotikController@inserDataMKT');



//------------------------------------Mikrotik------------------------------------
Route::get('/pagMikrotik', 'DispositivoController@index');
//insertar
Route::post('/pagMikrotik/crearDispositivo', 'DispositivoController@create');
//eliminar
Route::get('/pagMikrotik/Eliminar/{idDispositivo}', 'DispositivoController@destroy');

Route::get('/pagMikrotik/Desactivar/{idDispositivo}', 'DispositivoController@desactivar');

//id
Route::get('/pagMikrotik/Editar/{idDispositivo}','DispositivoController@editar');

Route::post('/pagMikrotik/Update/','DispositivoController@update');

Route::post('/pagMikrotik/f_checked','DispositivoController@checked');

/*1)Pagina Usuario*/
Route::get('/pagUsuario', 'UserController@index');
Route::post('/pagUsuario/crearUsuario', 'UserController@create');
Route::get('/pagUsuario/Eliminar/{idUSUARIO}', 'UserController@destroy');
