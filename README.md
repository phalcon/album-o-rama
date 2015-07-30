# Album O'Rama

Phalcon PHP is a web framework delivered as a C extension providing high
performance and lower resource consumption.

This is a sample application for the Phalcon PHP Framework. We expect to
implement as many features as possible to showcase the framework and its
potential.

Please write us if you have any feedback.

Thanks.

## NOTE

The master branch will always contain the latest stable version. If you wish
to check older versions or newer ones currently under development, please
switch to the relevant branch. 

## Get Started

### Requirements

To run this application on your machine, you need at least:

* [Composer][1]
* PHP >= 5.4
* [Apache Web Server][2] with [mod_rewrite][3] enabled or [Nginx][4]
* Latest stable [Phalcon Framework release][5] extension enabled

### Installation

Install composer in a common location or in your project:

```sh
$ curl -s http://getcomposer.org/installer | php
```

Create the composer.json file as follows:

```json
{
    "require": {
        "phalcon/album-o-rama": "dev-master"
    }
}
```

Run the composer installer:

```sh
$ php composer.phar install
```

Then you'll need to create the database and initialize schema:

```sh
$ echo 'CREATE DATABASE albumorama' | mysql -u root
$ cat schemas/albumorama.sql | mysql -u root albumorama
```

And set permissions for cache dirs:

```sh
$ chmod a+wx var/logs/
$ chmod a+wx var/cache/
$ chmod a+wx var/volt/
```

## License

Album O'Rama is open-sourced software licensed under the [New BSD License][6]. © Phalcon Framework Team and contributors

[1]: https://getcomposer.org/
[2]: http://httpd.apache.org/
[3]: http://httpd.apache.org/docs/current/mod/mod_rewrite.html
[4]: http://nginx.org/
[5]: https://github.com/phalcon/cphalcon/releases
[6]: https://github.com/phalcon/album-o-rama/blob/master/docs/LICENSE.md
