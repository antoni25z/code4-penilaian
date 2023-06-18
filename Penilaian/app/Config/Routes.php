<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('myapi/login', 'MyApi::login');

$routes->post('myapi/add_employee', 'MyApi::addEmployee');
$routes->post('myapi/update_employee/(:segment)', 'MyApi::updateEmployee/$1');
$routes->delete('myapi/delete_employee/(:segment)', 'MyApi::deleteEmployee/$1');
$routes->get('myapi/employees', 'MyApi::getEmployees');

$routes->get('myapi/dept', 'MyApi::getDept');

$routes->get('myapi/aspect_criteria', 'MyApi::getAspects');

$routes->post('myapi/add_aspect', 'MyApi::addAspect');
$routes->post('myapi/update_aspect/(:segment)', 'MyApi::updateAspect/$1');
$routes->delete('myapi/delete_aspect/(:segment)', 'MyApi::deleteAspect/$1');
$routes->get('myapi/aspects', 'MyApi::getAllAspects');

$routes->post('myapi/add_criteria', 'MyApi::addCriteria');
$routes->post('myapi/update_criteria/(:segment)', 'MyApi::updateCriteria/$1');
$routes->delete('myapi/delete_criteria/(:segment)', 'MyApi::deleteCriteria/$1');
$routes->get('myapi/criterias', 'MyApi::getAllCriterias');

$routes->post('myapi/add_result_rating', 'MyApi::addResultRating');

$routes->get('myapi/result_rating', 'MyApi::getResultRating');

$routes->post('myapi/reset_password', 'MyApi::resetPassword');
$routes->post('myapi/add_attendance', 'MyApi::addAttendance');

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
