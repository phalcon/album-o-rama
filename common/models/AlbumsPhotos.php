<?php

namespace AlbumOrama\Models;

class AlbumsPhotos extends \Phalcon\Mvc\Model
{

	public function getSource()
	{
		return 'albums_photos';
	}

	public function initialize()
	{
		$this->belongsTo('albums_id', 'AlbumOrama\Models\Albums', 'id');
	}

}