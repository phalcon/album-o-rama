<?php

namespace AlbumOrama\Components\Palette;

class Palette
{

	public static function adjustBrightness($hex, $steps)
	{
		// Steps should be between -255 and 255. Negative = darker, positive = lighter
		$steps = max(-255, min(255, $steps));

		// Format the hex color string
		$hex = str_replace('#', '', $hex);
		if (strlen($hex) == 3) {
			$hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
		}

		// Get decimal values
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));

		// Adjust number of steps and keep it inside 0 to 255
		$r = max(0,min(255,$r + $steps));
		$g = max(0,min(255,$g + $steps));
		$b = max(0,min(255,$b + $steps));

		$r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
		$g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
		$b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

		return '#'.$r_hex.$g_hex.$b_hex;
	}

	public static function convertColor($hex)
	{
		$hex = str_replace('#', '', $hex);
		if (strlen($hex) == 3) {
			$hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
		}

		// Get decimal values
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));

		return array('red' => $r, 'green' => $g, 'blue' => $b);
	}

	public static function compareColorsDarker($c1, $c2)
	{
		return $c1['red']+$c1['blue']+$c1['green'] > $c2['red']+$c2['blue']+$c2['green'];
	}

	public static function compareColorsLighter($c1, $c2)
	{
		return $c1['red']+$c1['blue']+$c1['green'] < $c2['red']+$c2['blue']+$c2['green'];
	}

	public static function calculate($file)
	{

		if (preg_match('/\.png$/i', $file)) {
			$image = imagecreatefrompng($file);
		} else {
			$image = imagecreatefromjpeg($file);
		}

		if ($image) {

			$stats = array();

			$darker = null;
			$lighter = null;

			for ($i = 0; $i < 64; $i++) {

				if ($i > 30 && $i < 40) {
					continue;
				}

				for ($j = 0; $j < 64; $j++) {

					if ($j > 30 && $j < 40) {
						continue;
					}

					$rgb = imagecolorat($image, $j, $i);

					$colors = imagecolorsforindex($image, $rgb);

					foreach(array('red', 'green', 'blue') as $ind){
						$x = $colors[$ind]%5;
						if($x!=0){
							$colors[$ind]-=$x;
						}
					}

					//Ignore darker colors
					if ($colors['red'] < 20 && $colors['blue'] < 20 && $colors['green'] < 20) {
						continue;
					}

					//Ignore lighter colors
					if ($colors['red'] > 250 && $colors['blue'] > 250 && $colors['green'] > 250) {
						continue;
					}

					if ($darker===null){
						$darker = $colors;
					} else {
						if (self::compareColorsDarker($darker, $colors)) {
							$darker = $colors;
						}
					}

					if ($lighter===null){
						$lighter = $colors;
					} else {
						if (self::compareColorsLighter($lighter, $colors)) {
							$lighter = $colors;
						}
					}

					$realcolor = sprintf("#%02X%02X%02X", $colors['red'], $colors['green'], $colors['blue']);
					if(!isset($stats[$realcolor])){
						$stats[$realcolor] = 1;
					} else {
						$stats[$realcolor]++;
					}

				}

			}

			asort($stats);

			$n = 1;
			foreach($stats as $color => $number){
				$n++;
			}

		}

		if(!isset($color)) {
			$color = '#ffffff';
			$lighter =  array('red' => 250, 'blue' => 250, 'green' => 250);
			$darker =  array('red' => 71, 'blue' => 71, 'green' => 71);
		}

		//print_r($lighter);

		if (self::compareColorsDarker(array('red' => 71, 'blue' => 71, 'green' => 71), self::convertColor($color))) {
			$title = sprintf("#%02X%02X%02X", $lighter['red'], $lighter['green'], $lighter['blue']);
			$titleColor = $lighter;
		} else {
			$title = sprintf("#%02X%02X%02X", $darker['red'], $darker['green'], $darker['blue']);
			$titleColor = $darker;
		}

		//if (self::compareSimilar())

		return array(
			'background' => $color,
			'title' => $title,
			'link' => self::adjustBrightness($title, -25),
			'link2' => self::adjustBrightness($title, +25),
			'light1' => self::adjustBrightness($title, -15),
			'light2' => self::adjustBrightness($title, -25),
			'light3' => self::adjustBrightness($title, -35),
			'light4' => self::adjustBrightness($color, 15),
			'light5' => self::adjustBrightness($color, 25),
			'dark1' => self::adjustBrightness($color, -25),
			'dark2' => self::adjustBrightness($color, -30)
		);

	}

	public static function write($path, $palette)
	{
		file_put_contents($path, '
body { background:'.$palette['background'].'; }
h1 { color: '.$palette['title'].' }
div#logo h1 { color: '.$palette['title'].' }
#menu-links ul > li a { color: '.$palette['link'].' }
#breadcrumbs { color: '.$palette['link'].' }
#breadcrumbs a { color: '.$palette['link'].'; }
table.album-showcast .release-date { color: '.$palette['light3'].' }
table.album-showcast .summary { color: '.$palette['light1'].' }
table.album-showcast a { color: '.$palette['link2'].' }
table.album-showcast .image img { border: 1px solid '.$palette['light4'].' }
table.tracks td { color: '.$palette['light1'].' }
table.tracks tr:nth-child(2n+1) { background-color: '.$palette['light5'].' }
#top-tags { background-color: '.$palette['light5'].' }
#tags-links li { color: '.$palette['link'].' }
#tags-links li a { color: '.$palette['link2'].' }
div#footer { background: '.$palette['dark2'].'; color: '.$palette['title'].'; }
div#footer a { color: '.$palette['title'].'; }
');
	}

}
