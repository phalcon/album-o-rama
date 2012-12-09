<?php

namespace AlbumOrama\Models;

class AlbumsPalette extends \Phalcon\Mvc\Model
{

	public function getSource()
	{
		return 'albums_palette';
	}

	public function initialize()
	{
		$this->belongsTo('albums_id', 'AlbumOrama\Models\Albums', 'id');
	}

}