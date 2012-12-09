<?php

namespace AlbumOrama\Models;

class ArtistsPhotos extends \Phalcon\Mvc\Model
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