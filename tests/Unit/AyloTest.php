<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Helper;

class AyloTest extends TestCase
{
	/**
	 * Test get api data and sitensme.
	 */
	public function test_get_api_data_and_correct_sitename(): void
	{
		ini_set('memory_limit', -1);
		$result = (new Helper())->getData("https://ph-c3fuhehkfqh6huc0.z01.azurefd.net/feed_pornstars.json");
		$site_is_pornhub = ($result->site == "https://www.pornhub.com" ? true : false);
		$this->assertTrue($site_is_pornhub);
	}

	/**
	 * Test number of items.
	 */
	public function test_number_of_items(): void
	{
		$dump_items = [];
		$limit = 20;
		for($i = 0; $i < $limit; $i++) {
			$dump_items[$i] = "testing data";
		}
		$result = (new Helper())->selectSpecificNumberOfItems($limit, $dump_items);
		$correct_number_of_items = (count($result) == $limit ? true : false);
		$this->assertTrue($correct_number_of_items);		
	}
}
