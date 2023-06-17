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
$routes->put('myapi/update_employee/(:id)', 'MyApi::updateEmployee/$1');
$routes->delete('myapi/delete_employee/(:id)', 'MyApi::deleteEmployee/$1');
$routes->get('myapi/employees/(:employee_name)', 'MyApi::getEmployees/$1');

$routes->get('myapi/dept', 'MyApi::getDept');

$routes->get('myapi/aspect_criteria', 'MyApi::getAspects');

$routes->post('myapi/add_aspect', 'MyApi::addAspect');
$routes->put('myapi/update_aspect/(:id)', 'MyApi::updateAspect');
$routes->delete('myapi/delete_aspect/(:id)', 'MyApi::deleteAspect');
$routes->get('myapi/aspects', 'MyApi::getAllAspects');

$routes->post('myapi/add_criteria', 'MyApi::addCriteria');
$routes->put('myapi/update_criteria/(:id)', 'MyApi::updateCriteria');
$routes->delete('myapi/delete_criteria/(:id)', 'MyApi::deleteCriteria');
$routes->get('myapi/criterias', 'MyApi::getAllCriterias');

$routes->post('myapi/add_result_rating', 'MyApi::addResultRating');

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
