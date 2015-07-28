<?php

namespace AlbumOrama\Models;

use Phalcon\Mvc\Model;

class AlbumsTags extends Model
{
	public function getSource()
	{
		return 'albums_tags';
	}

	public function initialize()
	{
		$this->belongsTo('albums_id', 'AlbumOrama\Models\Albums', 'id');
		$this->belongsTo('tags_id', 'AlbumOrama\Models\Tags', 'id');
	}
}
