<?php

namespace App;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Listing;
use App\Models\Atts;
use App\Models\Thumbnails;

class Helper
{
	/**
	 * Create a new class instance.
	 */
	public function __construct()
	{
		//
	}

	public function getData($url) {
		$response = Http::get($url);
		// We remove characters that will break json validation - we could use a range with preg_replace()
		$result = str_replace('\xF0', '', $response->getBody()->getContents());
		$data = json_decode($result);
		return $data;
	}

	public function selectSpecificNumberOfItems($number, $all_items) {
		for ($i = 0; $i < $number; $i++) {
				$items[$i] = $all_items[$i];
		}
		return $items;
	}

	public function retrieveImage($image_link) {
		// We use curl instead of file_get_contents()
		$ch = curl_init($image_link);
		// Useragent headers
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// We set this option to true so if the image is through riderected link, we will retrieve as well
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$retrieved_image = curl_exec($ch);
		// We can check for image size if we want
		$image_size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
		curl_close($ch);
		return $retrieved_image;
	}
}
