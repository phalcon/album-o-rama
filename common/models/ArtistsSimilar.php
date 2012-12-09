<?php

namespace AlbumOrama\Models;

class ArtistsSimilar extends \Phalcon\Mvc\Model
{

	public function getSource()
	{
		return 'artists_similar';
	}

	public function initialize()
	{
		$this->belongsTo('artists_id', 'AlbumOrama\Models\Artists', 'id');
	}

}