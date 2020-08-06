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
    return view('auth/login');
});
Route::resource('almacen/categoria','CategoriaController');
Route::resource('almacen/producto','ProductoController');
Route::resource('ventas/cliente','ClienteController');
Route::resource('ventas/pedido','PedidoController');
Route::resource('ventas/venta','VentaController');
Route::resource('seguridad/usuario','UsuarioController');

Route::get('reporte/pdf','ReporteController@generar');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/{slug?}', 'HomeController@index');
