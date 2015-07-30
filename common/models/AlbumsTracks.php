<?php

namespace AlbumOrama\Models;

use Phalcon\Mvc\Model;

class AlbumsTracks extends Model
{
    public function getSource()
    {
        return 'albums_tracks';
    }
}
