<?php

namespace AlbumOrama\Models;

use Phalcon\Mvc\Model;

class Tags extends Model
{
	public function getSource()
	{
		return 'tags';
	}

	public function initialize()
	{
		$this->hasMany('id', 'AlbumOrama\Models\AlbumsTags', 'tags_id');
	}
}
