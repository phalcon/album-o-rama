<?php

namespace AlbumOrama\Frontend;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Db\Adapter\Pdo\Mysql as Connection;

class Module implements ModuleDefinitionInterface
{
    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface $di Dependency Injection Container [Optional]
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'AlbumOrama\Frontend\Controllers' => __DIR__.'/controllers/',
            'AlbumOrama\Models'               => __DIR__.'/../../common/models/',
            'AlbumOrama\Components\Palette'   => __DIR__.'/../../common/library/Palette/',
        ]);

        $loader->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di Dependency Injection Container
     */
    public function registerServices(DiInterface $di)
    {
        /**
         * Read configuration
         */
        $config = require __DIR__."/config/config.php";

        /**
         * Setting up the view component
         */
        $di->setShared('view', function() {
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
        $di->setShared('db', function() use ($config) {
            return new Connection([
                'host'     => $config->database->host,
                'username' => $config->database->username,
                'password' => $config->database->password,
                'dbname'   => $config->database->dbname
            ]);
        });

    }

}
