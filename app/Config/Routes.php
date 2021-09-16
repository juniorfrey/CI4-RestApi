<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('/auth/login', 'Auth::login');
$routes->post('/auth/verificar', 'Auth::verifyToken');

//$routes->get('empleados', 'Empleados::index', ['filter' => 'authFilter']);

//$routes->resetRoutes('api', ['controller'=> 'Empleados']);

// GRUPO DE RUTAS
$routes->group('api', ['namespace' => 'App\Controllers\API', 'filter' => 'authFilter'], function($routes){
	$routes->get('empleados', 'Empleados::index');
	$routes->post('empleados/create', 'Empleados::create');
	$routes->get('empleados/edit/(:num)', 'Empleados::edit/$1');
	$routes->put('empleados/update/(:num)', 'Empleados::update/$1');
	$routes->delete('empleados/delete/(:num)', 'Empleados::delete/$1');
	$routes->get('usuarios', 'Users::getUsuarios');
	$routes->post('usuarios/create', 'Users::create');
	$routes->get('usuarios/byEmpUsuario/(:num)', 'Users::getUsuariosEmpleados/$1');
	$routes->post('usuarios/createuser','Users::crearUsuario');
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
