<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::index');
$routes->get('home', 'AuthController::activities');

// Idioma
$routes->get('lang/(:segment)', 'AuthController::setLanguage/$1');

// Autenticación (GET y POST)
$routes->get('login', 'AuthController::showLogin');
$routes->post('login', 'AuthController::processLogin');
$routes->get('register', 'AuthController::showRegistration');
$routes->post('register', 'AuthController::processRegistration');
$routes->get('verify-email', 'AuthController::verifyEmail');
$routes->get('forgot-password', 'AuthController::showForgotPassword');
$routes->post('send-reset', 'AuthController::sendReset');
$routes->get('reset-password', 'AuthController::showResetForm');
$routes->post('process-reset', 'AuthController::processResetPassword');
$routes->get('logout', 'AuthController::logout');

// Perfil de Usuario
$routes->get('profile', 'AuthController::profile');
$routes->get('profile/edit', 'AuthController::editProfile');
$routes->post('profile/verify-step', 'AuthController::verifyProfileStep');
$routes->get('profile/confirm-password', 'AuthController::confirmPasswordView');
$routes->post('profile/update', 'AuthController::updateProfile');
$routes->get('profile/change-password', 'AuthController::changePasswordView');
$routes->post('profile/update-password', 'AuthController::updatePassword');
$routes->get('profile/change-image', 'AuthController::changeImageView');
$routes->post('profile/update-image', 'AuthController::updateImage');
$routes->get('profile/delete-image', 'AuthController::deleteImage');

// Administración de Usuarios
$routes->group('admin/users', function($routes) {
    $routes->get('/', 'Admin\UsersController::index');
    $routes->get('create', 'Admin\UsersController::create');
    $routes->post('store', 'Admin\UsersController::store');
    $routes->get('show/(:num)', 'Admin\UsersController::show/$1');
    $routes->get('edit/(:num)', 'Admin\UsersController::edit/$1');
    $routes->post('update/(:num)', 'Admin\UsersController::update/$1');
    $routes->get('delete/(:num)', 'Admin\UsersController::delete/$1');
});

// Gestión de Tareas
$routes->group('tasks', function($routes) {
    $routes->get('/', 'TasksController::index');
    $routes->get('create', 'TasksController::create');
    $routes->post('store', 'TasksController::store');
    $routes->get('edit/(:num)', 'TasksController::edit/$1');
    $routes->post('update/(:num)', 'TasksController::update/$1');
    $routes->get('delete/(:num)', 'TasksController::delete/$1');
});
