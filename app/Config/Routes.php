<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


 //* Rutas Insumo
 $routes->get('insumos/nombre/(:segment)', 'InsumoController::showNombre/$1');
 $routes->resource('insumos', ['controller' => 'InsumoController']);

//* Rutas Proveedores
$routes->get('proveedores/nombre/(:segment)', 'ProveedorController::showNombre/$1');
$routes->resource('proveedores', ['controller' => 'ProveedorController']);

//* Rutas Solicitud
$routes->get('solicitudes/nombre/(:segment)', 'SolicitudController::showNombre/$1');
$routes->resource('solicitudes', ['controller' => 'SolicitudController']);


$routes->get('/', 'Home::index');
