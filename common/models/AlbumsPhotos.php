<?php

namespace AlbumOrama\Models;

use Phalcon\Mvc\Model;

class AlbumsPhotos extends Model
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
