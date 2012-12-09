<?php

$router = new \Phalcon\Mvc\Router();

/**
 * Frontend routes
 */
$router->add('', array(
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'index',
	'action' => 'index'
));

$router->add('/', array(
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'index',
	'action' => 'index'
));

$router->add('/index', array(
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'index',
	'action' => 'index'
));

$router->add('/artist/{id:[0-9]+}/{name}', array(
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'artist'
));

$router->add('/album/{id:[0-9]+}/{name}', array(
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'album',
));

$router->add('/play/{id:[0-9]+}', array(
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'play',
));

$router->add('/tag/{name}', array(
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'tag'
));

$router->add('/tag/{name}/{page:[0-9]+}', array(
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'tag'
));

$router->add('/search(/?)', array(
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'search'
));

$router->add('/popular', array(
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'popular'
));

$router->add('/charts', array(
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'charts'
));

$router->add('/about', array(
	'module' => 'frontend',
	'namespace' => 'AlbumOrama\Frontend\Controllers\\',
	'controller' => 'about',
	'action' => 'index'
));

/**
 * Backend routes
 */

return $router;
