<?php

namespace AlbumOrama\Models;

use Phalcon\Mvc\Model;

class AlbumsPalette extends Model
{
    public $id;
    public $albums_id;
    public $type;
    public $color;

    public function getSource()
    {
        return 'albums_palette';
    }

    public function initialize()
    {
        $this->belongsTo('albums_id', 'AlbumOrama\Models\Albums', 'id');
    }
}
