<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/shop', 'Home::shop');
$routes->get('/contact', 'Home::Contactus');
$routes->get('/About', 'Home::About');
$routes->get('/TermCondition', 'Home::TermCondition');
$routes->get('/Privacypolicy', 'Home::Privacypolicy');
$routes->get('/Faq', 'Home::Faq');

$routes->get('/Shop/(:num)', 'Home::Shop');
$routes->get('/single_product/(:num)', 'Home::Single_product');


$routes->get('/Register', 'Home::register');
$routes->get('/Profile', 'Home::Profile');



$routes->get('/admin', 'Admin::index');
$routes->post('/admin/login', 'Admin::loginAuth');



$routes->get('/vehicle-type', 'VehicleType::index');
$routes->post('/vehicle-type/add', 'VehicleType::add');
$routes->post('/vehicle-type/edit/(:num)', 'VehicleType::edit/$1');
$routes->post('/vehicle-type/status', 'VehicleType::status');
$routes->post('/vehicle-type/delete', 'VehicleType::delete');

$routes->get('/vehicle', 'Vehicle::index');
$routes->post('/vehicle/add', 'Vehicle::add');
$routes->post('/vehicle/edit/(:num)', 'Vehicle::edit/$1');
$routes->post('/vehicle/status', 'Vehicle::status');
$routes->post('/vehicle/delete', 'Vehicle::delete');

$routes->get('/service', 'Service::index');
$routes->post('/service/add', 'Service::add');
$routes->post('/service/edit/(:num)', 'Service::edit/$1');
$routes->post('/service/status', 'Service::status');
$routes->post('/service/delete', 'Service::delete');
$routes->post('/service/check-vehicle', 'Service::checkVehicleStatus');
$routes->post('/service/get-vehicle-list', 'Service::getVehicleList');


