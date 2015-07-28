<?php

namespace AlbumOrama\Models;

use Phalcon\Mvc\Model;

class Artists extends Model
{
	public function getSource()
	{
		return 'artists';
	}

	public function getPhoto($type)
	{
		$albumPhotos = $this->getPhotos('type = "'.$type.'"');
		if (count($albumPhotos)) {
			return $albumPhotos[0]->url;
		}
		return null;
	}

	public function getPhotos($parameters=null)
	{
		return $this->getRelated('AlbumOrama\Models\ArtistsPhotos', $parameters);
	}

	public function getAlbums($parameters=null)
	{
		return $this->getRelated('AlbumOrama\Models\Albums', $parameters);
	}

	public function initialize()
	{
		$this->hasMany('id', 'AlbumOrama\Models\ArtistsPhotos', 'artists_id');
		$this->hasMany('id', 'AlbumOrama\Models\Albums', 'artists_id');
	}
}
