<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route - automatically redirects to login
$routes->get('/', 'Auth::index');

// Authentication Routes
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::attemptRegister');
$routes->get('/logout', 'Auth::logout');

// Dashboard Route (accessible only when logged in)
$routes->get('/dashboard', 'Auth::dashboard');
$routes->get('/dashboard/switchRole/(:segment)', 'Auth::switchRole/$1');

// Student Routes
$routes->get('/student', 'User::index');
$routes->get('/student/courses', 'User::courses');
$routes->get('/student/course/(:num)', 'User::viewCourse/$1');
$routes->get('/student/enrollment', 'User::enrollment');
$routes->get('/student/assignments', 'User::assignments');
$routes->get('/student/grades', 'User::grades');

// Teacher Routes
$routes->get('/teacher', 'Teacher::index');
$routes->get('/teacher/courses', 'Teacher::classes');
$routes->get('/teacher/course/(:num)', 'Teacher::viewCourse/$1');
$routes->get('/teacher/assignments', 'Teacher::assignments');
$routes->get('/teacher/grades', 'Teacher::grades');

// Admin Routes
$routes->get('/admin', 'Admin::index');
$routes->get('/admin/users', 'Admin::users');
$routes->get('/admin/users/view/(:num)', 'Admin::viewUser/$1');
$routes->get('/admin/users/edit/(:num)', 'Admin::editUser/$1');
$routes->post('/admin/users/update/(:num)', 'Admin::updateUser/$1');
$routes->post('/admin/users/delete/(:num)', 'Admin::deleteUser/$1');
$routes->get('/admin/courses', 'Admin::courses');
$routes->get('/admin/courses/create', 'Admin::createCourse');
$routes->post('/admin/courses/store', 'Admin::storeCourse');
$routes->get('/admin/courses/view/(:num)', 'Admin::viewCourse/$1');
$routes->get('/admin/courses/edit/(:num)', 'Admin::editCourse/$1');
$routes->post('/admin/courses/update/(:num)', 'Admin::updateCourse/$1');
$routes->post('/admin/courses/delete/(:num)', 'Admin::deleteCourse/$1');
$routes->get('/admin/reports', 'Admin::reports');
$routes->get('/admin/settings', 'Admin::settings');
$routes->get('/admin/create-user', 'Admin::createUser');
$routes->post('/admin/create-user', 'Admin::storeUser');
$routes->get('/admin/user-management', 'Admin::userManagement');

// Course enrollment routes (if needed for future use)
$routes->post('/course/enroll', 'Course::enroll');

// Course search routes
$routes->get('/course/search', 'Course::search');
$routes->post('/course/search', 'Course::search');

// Materials routes
$routes->get('/admin/course/(:num)/upload', 'Materials::upload/$1');
$routes->post('/admin/course/(:num)/upload', 'Materials::upload/$1');
$routes->get('/materials/delete/(:num)', 'Materials::delete/$1');
$routes->get('/materials/download/(:num)', 'Materials::download/$1');

// Notifications routes
$routes->get('/notifications', 'Notifications::get');
$routes->post('/notifications/mark_read/(:num)', 'Notifications::mark_as_read/$1');
