<?php

$router = new \Phalcon\Mvc\Router(false);

$router->removeExtraSlashes(true);

/**
 * Frontend routes
 */
$router->add('', [
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'index',
	'action' => 'index'
]);

$router->add('/', [
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'index',
	'action' => 'index'
]);

$router->add('/index', [
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'index',
	'action' => 'index'
]);

$router->notFound([
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'index',
	'action' => 'route404'
]);

$router->add('/artist/{id:[0-9]+}/{name}', [
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'artist'
]);

$router->add('/album/{id:[0-9]+}/{name}', [
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'album',
]);

$router->add('/tag/{name}', [
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'tag'
]);

$router->add('/tag/{name}/{page:[0-9]+}', [
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'tag'
]);

$router->add('/search(/?)', [
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'catalog'
,	'action' => 'search'
]);

$router->add('/popular', [
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'popular'
]);

$router->add('/charts', [
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'charts'
]);

$router->add('/about', [
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'about',
	'action' => 'index'
]);

/**
 * Backend routes
 */

return $router;
