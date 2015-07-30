<?php

namespace AlbumOrama\Frontend;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Db\Adapter\Pdo\Mysql as Connection;

class Module
{
    public function registerAutoloaders()
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'AlbumOrama\Frontend\Controllers' => __DIR__.'/controllers/',
            'AlbumOrama\Models' => __DIR__.'/../../common/models/',
            'AlbumOrama\Components\Palette' => __DIR__.'/../../common/library/Palette/',
        ]);

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

            $view = new View();

            $view->setViewsDir(__DIR__.'/views/');

            $view->setTemplateBefore('main');

            $view->registerEngines([
                ".volt" => function($view, $di) {

                    $volt = new Volt($view, $di);

                    $volt->setOptions([
                        'compiledPath' => function ($templatePath) {
                            return realpath(__DIR__."/../../var/volt") . '/' . md5($templatePath) . '.php';
                        },
                        'compiledExtension' => '.php',
                        'compiledSeparator' => '%'
                    ]);

                    return $volt;
                }
            ]);

            return $view;

        });

        /**
         * Database connection is created based in the parameters defined in the configuration file
         */
        $di->set('db', function() use ($config) {
            return new Connection([
                "host" => $config->database->host,
                "username" => $config->database->username,
                "password" => $config->database->password,
                "dbname" => $config->database->name
            ]);
        });

    }

}
