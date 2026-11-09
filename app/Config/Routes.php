<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');

//halaman yang lain harus login terlebih dahulu
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('dashboard', 'Dashboard::index');


    $routes->get('categories', 'Categories::index');
    $routes->get('categories/new', 'Categories::new');
    $routes->post('categories/create', 'Categories::create');
    $routes->get('categories/edit/(:num)', 'Categories::edit/$1');
    $routes->post('categories/update/(:num)', 'Categories::update/$1');
    $routes->post('categories/delete/(:num)', 'Categories::delete/$1');

    $routes->get('books', 'Books::index');
    $routes->get('books/new', 'Books::new');
    $routes->post('books/create', 'Books::create');
    $routes->get('books/detail/(:num)', 'Books::detail/$1');
    $routes->get('books/edit/(:num)', 'Books::edit/$1');
    $routes->post('books/update/(:num)', 'Books::update/$1');
    $routes->post('books/delete/(:num)', 'Books::delete/$1');
    
    //halaman yang hanya bisa diakses oleh admin
    $routes->group('admin', ['filter' => 'role:admin'], static function ($routes) {
        $routes->get('users', 'Users::index');
        $routes->get('users/new', 'Users::new');
        $routes->post('users/create', 'Users::create');
        $routes->get('users/edit/(:num)', 'Users::edit/$1');
        $routes->post('users/update/(:num)', 'Users::update/$1');
        $routes->post('users/delete/(:num)', 'Users::delete/$1');
    });
});
