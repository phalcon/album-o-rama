<?php

namespace AlbumOrama\Models;

use AlbumOrama\Components\Palette\Palette;
use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Mvc\Model;

class Albums extends Model
{
    public $id;
    public $artists_id;
    public $name;
    public $uri;
    public $rank;
    public $playcount;
    public $release_date;
    public $summary;
    public $href;

    public function initialize()
    {
        $this->belongsTo('artists_id', 'AlbumOrama\Models\Artists', 'id');
        $this->hasMany('id', 'AlbumOrama\Models\AlbumsTags', 'albums_id');
        $this->hasMany('id', 'AlbumOrama\Models\AlbumsPhotos', 'albums_id');
        $this->hasMany('id', 'AlbumOrama\Models\AlbumsPalette', 'albums_id');
        $this->hasMany('id', 'AlbumOrama\Models\AlbumsTracks', 'albums_id');
    }

    public function getSource()
    {
        return 'albums';
    }

    public function loadPalette()
    {
        $paletteCss = '../public/css/albums/'.$this->id.'.css';
        if(file_exists($paletteCss)){
            return $paletteCss;
        }

        $albumPhoto = $this->getPhoto('medium');
        if ($albumPhoto) {
            // Get the palette colors based on the albums url
            $palette = Palette::calculate($albumPhoto);

            foreach($palette as $type => $color) {
                $albumPalette = new AlbumsPalette();
                $albumPalette->albums_id = $this->id;
                $albumPalette->type = $type;
                $albumPalette->color = $color;

                if ($albumPalette->save() == false) {
                    $messages = $albumPalette->getMessages();
                    throw new \Exception((string) $messages[0]);
                }
            }

            Palette::write($paletteCss, $palette);
            return $paletteCss;
        }

        file_put_contents($paletteCss, '');
    }

    /**
     * Returns related records based on defined relations
     *
     * @return Simple
     */
    public function getPalette()
    {
        return $this->getRelated('AlbumOrama\Models\AlbumsPalette');
    }

    /**
     * Returns related records based on defined relations
     *
     * @param mixed $parameters
     * @return Artists|null
     */
    public function getArtist($parameters = null)
    {
        return $this->getRelated('AlbumOrama\Models\Artists', $parameters);
    }

    /**
     * Returns photo url if any
     *
     * @param string $type Photo size
     * @return null|string
     */
    public function getPhoto($type)
    {
        $albumPhotos = $this->getPhotos('type = "'.$type.'"');

        if ($albumPhotos->count()) {
            return $albumPhotos->getFirst()->url;
        }

        return null;
    }

    /**
     * Returns related records based on defined relations
     *
     * @param mixed $parameters
     * @return Simple
     */
    public function getTracks($parameters = null)
    {
        return $this->getRelated('AlbumOrama\Models\AlbumsTracks', $parameters);
    }

    /**
     * Returns related records based on defined relations
     *
     * @param mixed $parameters
     * @return Simple
     */
    public function getPhotos($parameters = null)
    {
        return $this->getRelated('AlbumOrama\Models\AlbumsPhotos', $parameters);
    }
}
