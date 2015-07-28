<?php

namespace AlbumOrama\Models;

use Phalcon\Mvc\Model;

class ArtistsPhotos extends Model
{
	public function getSource()
	{
		return 'artists_photos';
	}

	public function initialize()
	{
		$this->belongsTo('artists_id', 'AlbumOrama\Models\Artists', 'id');
	}
}
