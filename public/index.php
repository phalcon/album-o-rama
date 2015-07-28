<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Url;
use Phalcon\Session\Adapter\Files as FileSession;
use Phalcon\Cache\Frontend\Output as FrontendCache;
use Phalcon\Cache\Backend\File as BackendCache;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Logger;
use Phalcon\Mvc\Application;
use Phalcon\Exception;

error_reporting(-1);

try {

	/**
	 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
	 */
	$di = new FactoryDefault();

	/**
	 * Registering a router
	 */
	$di->set('router', require __DIR__.'/../common/config/routes.php');

	/**
	 * The URL component is used to generate all kind of urls in the application
	 */
	$di->set('url', function() {
		$url = new Url();
		$url->setBaseUri('/'); // If the project isn't in the Document Root folder, set setBaseUri to '/<relative-path-here>/'
		return $url;
	});

	/**
	 * Start the session the first time some component request the session service
	 */
	$di->set('session', function() {
		$session = new FileSession();
		$session->start();
		return $session;
	});

	//Set the views cache service
	$di->set('viewCache', function(){

		//Cache data for one day by default
		$frontCache = new FrontendCache(["lifetime" => 86400]);

		//File backend settings
		$cache = new BackendCache($frontCache, ["cacheDir" => __DIR__."/../var/cache/",]);

		return $cache;
	});

	/**
	 * Main logger file
	 */
	$di->set('logger', function() {
		return new FileLogger(__DIR__.'/../var/logs/'.date('Y-m-d').'.log');
	}, true);

	/**
	 * Error handler
	 */
	set_error_handler(function($errno, $errstr, $errfile, $errline) use ($di) {
		if (!(error_reporting() & $errno)) {
			return;
		}

		$di->getFlash()->error($errstr);
		$di->getLogger()->log($errstr.' '.$errfile.':'.$errline, Logger::ERROR);

		return true;
	});

	/**
	 * Handle the request
	 */
	$application = new Application();

	$application->setDI($di);

	/**
	 * Register application modules
	 */
	$application->registerModules(require __DIR__.'/../common/config/modules.php');

	echo $application->handle()->getContent();

} catch (Exception $e) {
	echo $e->getMessage();
} catch (PDOException $e){
	echo $e->getMessage();
}
