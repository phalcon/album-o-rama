<?php

error_reporting(-1);

try {

	/**
	 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
	 */
	$di = new \Phalcon\DI\FactoryDefault();

	/**
	 * Registering a router
	 */
	$di->set('router', require __DIR__.'/../common/config/routes.php');

	/**
	 * The URL component is used to generate all kind of urls in the application
	 */
	$di->set('url', function() {
		$url = new \Phalcon\Mvc\Url();
		$url->setBaseUri('/album-orama/');
		return $url;
	});

	/**
	 * Start the session the first time some component request the session service
	 */
	$di->set('session', function() {
		$session = new \Phalcon\Session\Adapter\Files();
		$session->start();
		return $session;
	});

	//Set the views cache service
	$di->set('viewCache', function(){

		//Cache data for one day by default
		$frontCache = new Phalcon\Cache\Frontend\Output(array(
			"lifetime" => 86400
		));

		//File backend settings
		$cache = new Phalcon\Cache\Backend\File($frontCache, array(
			"cacheDir" => __DIR__."/../var/cache/",
		));

		return $cache;
	});

	/**
	 * Main logger file
	 */
	$di->set('logger', function() {
		return new \Phalcon\Logger\Adapter\File(__DIR__.'/../var/logs/'.date('Y-m-d').'.log');
	}, true);

	/**
	 * Error handler
	 */
	set_error_handler(function($errno, $errstr, $errfile, $errline) use ($di)
	{
		if (!(error_reporting() & $errno)) {
			return;
		}

		$di->getLogger()->log($errstr.' '.$errfile.':'.$errline, Phalcon\Logger::ERROR);

		return true;
	});

	/**
	 * Handle the request
	 */
	$application = new \Phalcon\Mvc\Application();

	$application->setDI($di);

	/**
	 * Register application modules
	 */
	$application->registerModules(require __DIR__.'/../common/config/modules.php');

	echo $application->handle()->getContent();

} catch (Phalcon\Exception $e) {
	echo $e->getMessage();
} catch (PDOException $e){
	echo $e->getMessage();
}
