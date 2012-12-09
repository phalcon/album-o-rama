<?php

namespace AlbumOrama\Frontend\Controllers;

class IndexController extends ControllerBase
{

	public function indexAction()
	{

		$offset = mt_rand(0, 1000);
		$key = 'index'.$offset;

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
			LIMIT 30
			OFFSET '.$offset;
			$albums = $this->modelsManager->executeQuery($phql);

			$this->view->setVar('albums', $albums);

			//Top tags
			$phql = 'SELECT t.name, COUNT(*)
			FROM AlbumOrama\Models\Tags t
			JOIN AlbumOrama\Models\AlbumsTags at
			GROUP BY 1
			HAVING COUNT(*) > 50
			LIMIT 10
			OFFSET '.mt_rand(0, 50);
			$tags = $this->modelsManager->executeQuery($phql);

			$this->view->setVar('tags', $tags);

		}

		$this->view->cache(array("key" => $key));
	}

}

