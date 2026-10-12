<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/add', 'Home::add');
$routes->post('/search', 'Home::search');
$routes->post('/download', 'Home::download');
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::process');
$routes->get('logout', 'Auth::logout');