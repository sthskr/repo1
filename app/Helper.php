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
}
