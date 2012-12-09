<?php

namespace AlbumOrama\Models;

class Tags extends \Phalcon\Mvc\Model
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