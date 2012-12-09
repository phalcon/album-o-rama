<?php

namespace AlbumOrama\Models;

class ArtistsTags extends \Phalcon\Mvc\Model
{

	public function getSource()
	{
		return 'artists_tags';
	}

	public function initialize()
	{
		$this->belongsTo('artists_id', 'AlbumOrama\Models\Artists', 'id');
		$this->belongsTo('tags_id', 'AlbumOrama\Models\Tags', 'id');
	}

}