<?php

namespace AlbumOrama\Frontend;

class Module
{

	public function registerAutoloaders()
	{

		$loader = new \Phalcon\Loader();

		$loader->registerNamespaces(array(
			'AlbumOrama\Frontend\Controllers' => __DIR__.'/controllers/',
			'AlbumOrama\Models' => __DIR__.'/../../common/models/',
			'AlbumOrama\Components\Palette' => __DIR__.'/../../common/library/Palette/',
		));

		$loader->register();
	}

	public function registerServices($di)
	{

		/**
		 * Read configuration
		 */
		$config = require __DIR__."/config/config.php";

		/**
		 * Setting up the view component
		 */
		$di->set('view', function() {

			$view = new \Phalcon\Mvc\View();

			$view->setViewsDir(__DIR__.'/views/');

			$view->setTemplateBefore('main');

			$view->registerEngines(array(
				".volt" => function($view, $di) {

					$volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);

					$volt->setOptions(array(
						"compiledPath" => __DIR__."/../../var/volt/",
						"compiledExtension" => ".php"
					));

					return $volt;
				}
			));

			return $view;

		});

		/**
		 * Database connection is created based in the parameters defined in the configuration file
		 */
		$di->set('db', function() use ($config) {
			return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
				"host" => $config->database->host,
				"username" => $config->database->username,
				"password" => $config->database->password,
				"dbname" => $config->database->name
			));
		});

	}

}