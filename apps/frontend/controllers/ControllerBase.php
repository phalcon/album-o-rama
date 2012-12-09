<?php

namespace AlbumOrama\Frontend\Controllers;

use Phalcon\Tag;

class ControllerBase extends \Phalcon\Mvc\Controller
{

	protected function initialize()
	{
		Tag::setTitle('Album-O-Rama');
	}

}