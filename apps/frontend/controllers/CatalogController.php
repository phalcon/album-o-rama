<?php

namespace AlbumOrama\Frontend\Controllers;

use AlbumOrama\Models\Artists,
	AlbumOrama\Models\Albums,
	AlbumOrama\Models\Tags;

class CatalogController extends ControllerBase
{

	public function indexAction()
	{

	}

	public function artistAction($artistId, $artistName)
	{

		$key = 'artist'.$artistId;

		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {

			$artist = Artists::findFirst(array(
				'id = ?0', 'bind' => array($artistId)
			));
			if ($artist == false) {
				return $this->dispatcher->forward(array(
					'controller' => 'index',
					'action' => 'index'
				));
			}

			//Main tags
			$phql = 'SELECT t.name
			FROM AlbumOrama\Models\ArtistsTags at
			JOIN AlbumOrama\Models\Tags t
			WHERE at.artists_id = '.$artist->id.'
			LIMIT 10';
			$tags = $this->modelsManager->executeQuery($phql);

			//Top albums
			$phql = 'SELECT
			al.id,
			al.name,
			al.uri,
			ap.url
			FROM AlbumOrama\Models\Albums al
			JOIN AlbumOrama\Models\AlbumsPhotos ap
			WHERE
			ap.type = "large" AND
			al.artists_id = '.$artist->id.' AND
			al.playcount > 25000
			ORDER BY al.playcount DESC
			LIMIT 18';
			$albums = $this->modelsManager->executeQuery($phql);

			//Similar Artists
			$phql = 'SELECT
			ar.id,
			ar.name,
			ar.uri,
			ap.url
			FROM AlbumOrama\Models\ArtistsSimilar ars,
			AlbumOrama\Models\Artists ar,
			AlbumOrama\Models\ArtistsPhotos ap
			WHERE
			ars.similar_artist_id = ar.id AND
			ars.similar_artist_id = ap.artists_id AND
			ap.type = "large" AND
			ars.artists_id = '.$artist->id.'
			ORDER BY ar.listeners DESC
			LIMIT 10';
			$similars = $this->modelsManager->executeQuery($phql);

			$this->view->setVar('artist', $artist);
			$this->view->setVar('albums', $albums);
			$this->view->setVar('similars', $similars);
			$this->view->setVar('tags', $tags);
			$this->view->setVar('photo', $artist->getPhoto('extralarge'));

		}

		$this->view->cache(array("key" => $key));
	}

	public function albumAction($albumId, $albumName)
	{

		$key = 'album'.$albumId;

		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {

			$album = Albums::findFirst(array(
				'id = ?0', 'bind' => array($albumId)
			));
			if ($album == false) {
				return $this->dispatcher->forward(array(
					'controller' => 'index',
					'action' => 'index'
				));
			}

			//Top tags
			$phql = 'SELECT t.name
			FROM AlbumOrama\Models\AlbumsTags at
			JOIN AlbumOrama\Models\Tags t
			WHERE
			at.albums_id = '.$album->id.'
			LIMIT 10';
			$tags = $this->modelsManager->executeQuery($phql);

			//Top albums
			$phql = 'SELECT
			al.id,
			al.name,
			al.uri
			FROM AlbumOrama\Models\Albums al
			WHERE
			al.id <> '.$album->id.' AND
			al.artists_id = '.$album->artists_id.' AND
			al.playcount > 25000
			ORDER BY al.playcount DESC
			LIMIT 5';
			$relatedAlbums = $this->modelsManager->executeQuery($phql);

			$album->loadPalette();

			$this->view->setVar('album', $album);
			$this->view->setVar('relatedAlbums', $relatedAlbums);
			$this->view->setVar('artist', $album->getArtist());
			$this->view->setVar('tags', $tags);
			$this->view->setVar('tracks', $album->getTracks());
			$this->view->setVar('photo', $album->getPhoto('extralarge'));

		}

		$this->view->cache(array("key" => $key));

	}

	 public function tagAction($tagName, $page=1)
	{

		$page = $this->filter->sanitize($page, 'int');
		if ($page < 1) {
			$page = 1;
		}

		$tag = Tags::findFirst(array(
			'name = ?0', 'bind' => array($tagName)
		));
		if ($tag == false) {
			return $this->dispatcher->forward(array(
				'controller' => 'index',
				'action' => 'index'
			));
		}

		$key = 'tag'.$tag->id.'p'.$page;

		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {

			//Top albums
			$phql = 'SELECT
			al.id,
			al.name,
			ar.uri,
			ar.id as artist_id,
			ar.name as artist,
			ap.url
			FROM AlbumOrama\Models\Albums al
			JOIN AlbumOrama\Models\Artists ar
			JOIN AlbumOrama\Models\AlbumsTags at
			JOIN AlbumOrama\Models\AlbumsPhotos ap
			WHERE
			ap.type = "large" AND
			at.tags_id = '.$tag->id.'
			ORDER BY al.playcount DESC
			LIMIT 30
			OFFSET '.(($page-1)*30);
			$albums = $this->modelsManager->executeQuery($phql);

			$this->view->setVar('tag', $tag);
			$this->view->setVar('albums', $albums);
			$this->view->setVar('page', $page);
			$this->view->setVar('prev', $page == 1 ? 0 : $page-1);
			$this->view->setVar('next', count($albums) == 30 ? $page+1 : 0);

		}

		$this->view->cache(array("key" => $key));

	}

	public function searchAction()
	{

		//Top albums
		$phql = 'SELECT
		ar.id,
		ar.name,
		ar.uri,
		ap.url
		FROM AlbumOrama\Models\Artists ar
		JOIN AlbumOrama\Models\ArtistsPhotos ap
		WHERE
		ap.type = "large" AND
		ar.name LIKE ?0
		ORDER BY ar.listeners DESC
		LIMIT 30';

		$artists = $this->modelsManager->executeQuery($phql, array(
			'%'.preg_replace('/[ ]+/', '%', $this->request->getPost('s')).'%'
		));

		$this->view->setVar('artists', $artists);

	}

	public function popularAction()
	{

		$key = 'popular';

		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {

			//Top albums
			$phql = 'SELECT
			al.id,
			al.name,
			ar.uri,
			ar.id as artist_id,
			ar.name as artist,
			ap.url
			FROM AlbumOrama\Models\Albums al
			JOIN AlbumOrama\Models\Artists ar
			JOIN AlbumOrama\Models\AlbumsPhotos ap
			WHERE
			ap.type = "large"
			ORDER BY al.playcount DESC
			LIMIT 30';
			$albums = $this->modelsManager->executeQuery($phql);

			$this->view->setVar('albums', $albums);

			//Top tags
			$phql = 'SELECT t.name, COUNT(*)
			FROM AlbumOrama\Models\Tags t
			JOIN AlbumOrama\Models\AlbumsTags at
			GROUP BY 1
			HAVING COUNT(*) > 50
			LIMIT 14';
			$tags = $this->modelsManager->executeQuery($phql);

			$this->view->setVar('tags', $tags);

		}

		$this->view->cache(array("key" => $key));
	}

	/**
	 * This action handles the /charts route
	 */
	public function chartsAction()
	{

		$key = 'charts';

		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {

			$tagGenres = array(
				'pop', 'rock', 'rap',
				'rnb', 'electronic', 'alternative',
				'folk', 'country', 'hip-hop',
				'dance', 'chillout', 'trip-hop',
				'metal', 'ambient', 'soul',
				'jazz', 'latin', 'punk'
			);

			$charts = array();
			foreach ($tagGenres as $genre) {

				$tag = Tags::findFirst(array(
					'name = ?0', 'bind' => array($genre)
				));
				if ($tag == false) {
					continue;
				}

				//Top albums
				$phql = 'SELECT
				al.id,
				al.name,
				ar.uri,
				ar.id as artist_id,
				ar.name as artist,
				ap.url
				FROM AlbumOrama\Models\Albums al
				JOIN AlbumOrama\Models\Artists ar
				JOIN AlbumOrama\Models\AlbumsTags at
				JOIN AlbumOrama\Models\AlbumsPhotos ap
				WHERE
				ap.type = "small" AND
				at.tags_id = '.$tag->id.'
				ORDER BY al.playcount DESC
				LIMIT 10';
				$charts[$tag->name] = $this->modelsManager->executeQuery($phql);
			}

			$this->view->setVar('charts', $charts);

		}

		$this->view->cache(array("key" => $key));
	}

}