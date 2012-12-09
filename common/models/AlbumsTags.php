<?php

namespace AlbumOrama\Models;

class AlbumsTags extends \Phalcon\Mvc\Model
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