<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultController('Maps');

$routes->get('/', 'Maps::index');
$routes->get('/Maps/index', 'Maps::index');
$routes->post('/Maps/index', 'Maps::index');
// $routes->get('/kode-wilayah/index', 'KodeWilayah::index');
$routes->get('/KodeWilayah/index', 'KodeWilayah::index');
$routes->get('/KodeWilayah/import', 'KodeWilayah::import');
$routes->post('/KodeWilayah/import', 'KodeWilayah::import');
// $routes->get('/', 'KodeWilayah::index');
$routes->get('/Data/index', 'Data::index');
$routes->get('/Data/import', 'Data::import');
$routes->post('/Data/import', 'Data::import');