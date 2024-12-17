<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('member', ['filter' => 'auth', 'namespace' => 'App\Modules\Member\Controllers'], function($routes){
	$routes->get('/', 'Member::index', ['filter' => 'permit:viewKontak']);
});

$routes->group('api', ['filter' => 'jwtauth', 'namespace' => 'App\Modules\Member\Controllers\Api'], function($routes){
    $routes->get('member', 'Member::index', ['filter' => 'permit:viewKontak']);
	$routes->get('member/(:segment)', 'Member::show/$1', ['filter' => 'permit:viewKontak']);
	$routes->post('member/save', 'Member::create', ['filter' => 'permit:createKontak']);
	$routes->put('member/update/(:segment)', 'Member::update/$1', ['filter' => 'permit:updateKontak']);
	$routes->delete('member/delete/(:segment)', 'Member::delete/$1', ['filter' => 'permit:deleteKontak']);

	$routes->get('jenis_member', 'MemberJenis::index', ['filter' => 'permit:viewKontak']);
	$routes->get('jenis_member/(:segment)', 'MemberJenis::show/$1', ['filter' => 'permit:viewKontak']);
	$routes->post('jenis_member/save', 'MemberJenis::create', ['filter' => 'permit:createKontak']);
	$routes->put('jenis_member/update/(:segment)', 'MemberJenis::update/$1', ['filter' => 'permit:updateKontak']);
	$routes->delete('jenis_member/delete/(:segment)', 'MemberJenis::delete/$1', ['filter' => 'permit:deleteKontak']);
});