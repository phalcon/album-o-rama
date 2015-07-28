<?php

namespace AlbumOrama\Models;

use Phalcon\Mvc\Model;

class ArtistsSimilar extends Model
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
