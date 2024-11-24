<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Listing;
use App\Models\Thumbnails;
use App\Models\Atts;

class AyloTest extends TestCase
{
	use RefreshDatabase;

	/**
	 * Test default url
	 */
	public function test_default_route_returns_a_successful_response_with_page_title(): void
	{
		$response = $this->get('/');
		$response->assertStatus(200);
		$response->assertSee("Aylo Assignment");
	}

	/**
	 * Test endpoint url.
	 */
	public function test_endpoint_route_returns_a_successful_response(): void
	{
		$response = $this->get('/endpoint');
		$response->assertStatus(200);
	}

	/**
	 * Test data insertion at database tables and display data to default route.
	 */
	public function test_create_item_in_database_and_display_data_to_default_route(): void
	{
		Listing::create([ "name" => "test_name", "link" => "test_link", "image" => "test_image_path"]);
		$listing_item_id = Listing::latest()->first()->id;
		Atts::create(["listing_id" => $listing_item_id, "hair_color" => "test_haircolor", "ethnicity" => "test_ethnicity", "tattoos" => "test_tattoos", "piercings" => "test_piercings", "breastsize" => "test_breastsize", "breasttype" => "test_breasttype", "gender" => "test_gender", "orientation" => "test_orientation", "age" => "test_age"]);
		Thumbnails::create(["listing_id" => $listing_item_id, "pc" => "test_pc_link", "mobile" => "test_mobile_link", "tablet" => "test_tablet_link"]);
		$response = $this->get('/');
		$response->assertSee("test_name");
		$response->assertSee("test_link");
		$response->assertSee("test_image_path");
		$response->assertSee("test_haircolor");
		$response->assertSee("test_ethnicity");
		$response->assertSee("test_orientation");
		$response->assertSee("test_age");
		$response->assertSee("test_gender");
	}

	/**
	 * Test data insertion at database tables and expose data to endpoint.
	 */
	public function test_create_item_in_database_and_expose_data_to_endpoint(): void
	{
		Listing::create([ "name" => "test_name", "link" => "test_link", "image" => "test_image_path"]);
		$listing_item_id = Listing::latest()->first()->id;
		Atts::create(["listing_id" => $listing_item_id, "hair_color" => "test_haircolor", "ethnicity" => "test_ethnicity", "tattoos" => "test_tattoos", "piercings" => "test_piercings", "breastsize" => "test_breastsize", "breasttype" => "test_breasttype", "gender" => "test_gender", "orientation" => "test_orientation", "age" => "test_age"]);
		Thumbnails::create(["listing_id" => $listing_item_id, "pc" => "test_pc_link", "mobile" => "test_mobile_link", "tablet" => "test_tablet_link"]);
		$response = $this->get('/endpoint');
		$response->assertSee("test_name");
		$response->assertSee("test_link");
		$response->assertSee("test_image_path");
		$response->assertSee("test_haircolor");
		$response->assertSee("test_ethnicity");
		$response->assertSee("test_orientation");
		$response->assertSee("test_tattoos");
		$response->assertSee("test_piercings");
		$response->assertSee("test_age");
		$response->assertSee("test_gender");
	}
}
