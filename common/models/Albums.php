<?php

namespace AlbumOrama\Models;

use AlbumOrama\Components\Palette\Palette;

class Albums extends \Phalcon\Mvc\Model
{

	public $id;

	public $artists_id;

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

		//$albumPalette = $this->getAlbumPalette();
		//if (count($albumPalette)) {
		//	$palette = array();
		//	foreach ($albumPalette as $paletteItem) {
		//		$palette[$paletteItem->type] = $paletteItem->color;
		//	}
		//	Palette::write($paletteCss, $palette);
		//	return $paletteCss;
		//}

		$albumPhoto = $this->getPhoto('medium');
		if ($albumPhoto) {

			/**
			 * Get the palette colors based on the albums url
			 */
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

	public function getPalette()
	{
		return $this->getRelated('AlbumOrama\Models\AlbumsPalette');
	}

	public function getArtist($parameters=null)
	{
		return $this->getRelated('AlbumOrama\Models\Artists', $parameters);
	}

	public function getPhoto($type)
	{
		$albumPhotos = $this->getPhotos('type = "'.$type.'"');
		if (count($albumPhotos)) {
			return $albumPhotos[0]->url;
		}
		return null;
	}

	public function getTracks($parameters=null)
	{
		return $this->getRelated('AlbumOrama\Models\AlbumsTracks', $parameters);
	}

	public function getPhotos($parameters=null)
	{
		return $this->getRelated('AlbumOrama\Models\AlbumsPhotos', $parameters);
	}

	public function initialize()
	{
		$this->belongsTo('artists_id', 'AlbumOrama\Models\Artists', 'id');
		$this->hasMany('id', 'AlbumOrama\Models\AlbumsTags', 'albums_id');
		$this->hasMany('id', 'AlbumOrama\Models\AlbumsPhotos', 'albums_id');
		$this->hasMany('id', 'AlbumOrama\Models\AlbumsPalette', 'albums_id');
		$this->hasMany('id', 'AlbumOrama\Models\AlbumsTracks', 'albums_id');
	}

}
