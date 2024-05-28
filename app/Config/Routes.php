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
$routes->post('/vehicle/create', 'Vehicle::create');
$routes->post('/vehicle/add', 'Vehicle::add');
$routes->post('/vehicle/edit/(:num)', 'Vehicle::edit/$1');
$routes->post('/vehicle/update/(:num)', 'Vehicle::update/$1');
$routes->post('/vehicle/status', 'Vehicle::status');
$routes->post('/vehicle/delete', 'Vehicle::delete');
$routes->post('/vehicle/update-driver', 'Vehicle::updateDriver');
$routes->get('/vehicle/driver-vehicle', 'Vehicle::driverVehicle');

$routes->get('/vehicle/accept/(:num)', 'Vehicle::acceptRequest/$1');
$routes->get('/vehicle/reject/(:num)', 'Vehicle::rejectRequest/$1');
$routes->get('/vehicle/leave/(:num)', 'Vehicle::leaveVehicle/$1');



$routes->get('/service', 'Service::index');
$routes->post('/service/add', 'Service::add');
$routes->post('/service/edit/(:num)', 'Service::edit/$1');
$routes->post('/service/status', 'Service::status');
$routes->post('/service/delete', 'Service::delete');
$routes->post('/service/check-vehicle', 'Service::checkVehicleStatus');
$routes->post('/service/get-vehicle-list', 'Service::getVehicleList');

$routes->get('/service-rate', 'SeviceRate::index');
$routes->post('/service-rate/add', 'SeviceRate::add');
$routes->post('/service-rate/edit/(:num)', 'SeviceRate::edit/$1');
$routes->post('/service-rate/status', 'SeviceRate::status');
$routes->post('/service-rate/delete', 'SeviceRate::delete');

$routes->get('/service-booking', 'ServiceBooking::index');
$routes->post('/service-booking/add', 'ServiceBooking::add');
$routes->post('/service-booking/status', 'ServiceBooking::status');

$routes->get('/service-request', 'ServiceRequest::index');
$routes->post('/service-request/status', 'ServiceRequest::status');


// API Routes 
$routes->get('api/get-vehcle-type', 'ApiController::vehcileTypeMaster');
$routes->post('api/sendOtpForLogin', 'ApiController::sendOtpForLogin');
$routes->post('api/verifyOtpForLogin', 'ApiController::verifyOtpForLogin');
$routes->post('api/updateProfile', 'ApiController::updateProfile');
$routes->post('api/get-price', 'ApiController::getServicePrice');
$routes->post('api/scedule-service', 'ApiController::sceduleService');
$routes->post('api/start-service', 'ApiController::startService');
$routes->post('api/send-live-location', 'ApiController::sendLiveLocation');
$routes->post('api/driver-login', 'ApiController::sendOtpForLoginDriver');
$routes->post('api/book-service', 'ApiController::bookService');
$routes->post('api/get-request', 'ApiController::getAllRequest');
$routes->post('api/accept-booking', 'ApiController::acceptBooking');
$routes->post('api/reject-booking', 'ApiController::rejectBooking');
$routes->post('api/end-booking', 'ApiController::endBooking');
$routes->post('api/check-booking-status', 'ApiController::checkBookingService');
$routes->post('api/verify-booking-otp', 'ApiController::verifyBookingOtp');
$routes->post('api/get-profile-details', 'ApiController::profileDetails');
$routes->post('api/get-service-list', 'ApiController::sceduleList');
$routes->post('api/get-customer-booking-history', 'ApiController::bookingHistoryCustomer');
$routes->post('api/cancel-booking', 'ApiController::cancelBooking');

$routes->post('api/register-driver', 'ApiController::driverRegister');
$routes->post('api/driver-update-profile', 'ApiController::driverUpdateProfile');
$routes->post('api/get-all-notification', 'ApiController::getAllNotification');

$routes->post('api/add-ratting-review', 'ApiController::addRatingReviews');
$routes->post('api/edit-ratting-review', 'ApiController::editRattingReview');
$routes->post('api/get-booking-ratting-review', 'ApiController::getBookingRatting');
$routes->post('api/edit-scedule-service', 'ApiController::editSceduleService');
$routes->post('api/get-current-service', 'ApiController::onGoingRide');

$routes->post('api/send-notification-temp', 'ApiController::sendPushNotificationTemp');


