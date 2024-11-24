<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Listing;
use App\Models\Atts;
use App\Models\Thumbnails;
use Illuminate\Support\Facades\Schedule;
use App\Helper;

Schedule::command('retrieve-api-data')->daily();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('retrieve-api-data', function () {
  ini_set('memory_limit', -1);
  // We will not store all data from url, for simplicity we will use the necessary (name, link, image, attributes..)
  $retrieve_data = new Helper();
  $apiUrl = "https://ph-c3fuhehkfqh6huc0.z01.azurefd.net/feed_pornstars.json";
  $data = $retrieve_data->getData($apiUrl);
  $count_all_items = $data->itemsCount;
  $all_items = $data->items;
  unset($data);
  // If we want to store all items we will use the $count_all_items variable otherwise we will set a number: $number_of_items = 200
  $number_of_items = $count_all_items;
  $items = $retrieve_data->selectSpecificNumberOfItems($number_of_items, $all_items);
  unset($all_items);
  // We set a default image for items that have not image url
  $default_image = "storage/default-avatar.png";
  foreach($items as $item) {
    // We make necessary checks to avoid errors that will break the functionality
    if (isset($item->name)) {
      $name = $item->name;
    } else {
      $name = '';
    }
    if (isset($item->link)) {
      $link = $item->link;
    } else {
      $link = '';
    }
    if (isset($item->attributes->age)) {
      $age = $item->attributes->age;
    } else {
      $age = '';
    }
    if (isset($item->attributes->tattoos)) {
      $tattoos = $item->attributes->tattoos;
    } else {
      $tattoos = '';
    }
    if (isset($item->attributes->breastSize)) {
      $breastsize = $item->attributes->breastSize;
    } else {
      $breastsize = '';
    }
    if (isset($item->attributes->breastType)) {
      $breasttype = $item->attributes->breastType;
    } else {
      $breasttype = '';
    }
    if (isset($item->attributes->ethnicity)) {
      $ethnicity = $item->attributes->ethnicity;
    } else {
      $ethnicity = '';
    }
    if (isset($item->attributes->hairColor)) {
      $haircolor = $item->attributes->hairColor;
    } else {
      $haircolor = '';
    }
    if (isset($item->attributes->piercings)) {
      $piercings = $item->attributes->piercings;
    } else {
      $piercings = '';
    }
    if (isset($item->attributes->gender)) {
      $gender = $item->attributes->gender;
    } else {
      $gender = '';
    }
    if (isset($item->attributes->orientation)) {
      $orientation = $item->attributes->orientation;
    } else {
      $orientation = '';
    }
    if (isset($item->thumbnails) && ($item->thumbnails != null)) {
      foreach($item->thumbnails as $thumbnail) {
        if(isset($thumbnail->type)) {
          if (isset($thumbnail->type) && ($thumbnail->type == "pc")) {
            // We will use only the "pc link" for simplicity
            // We could download 3 images for every item and store in different folders
            // and in blade template we could use in html srcset with the 3 images for responsive screens
            $pc_link = $thumbnail->urls[0];
            // Download image from url and store at storage/app/public/assets
            $retrieved_image = $retrieve_data->retrieveImage($pc_link);
            // We set uniq id for filename so even with the same name, we will not have conflicts
            $image_filename = uniqid() . '.jpg';
            $image_path = 'assets/' . $image_filename;
            Storage::disk('public')->put('assets/' . $image_filename, $retrieved_image);
          }
          // We keep store other 2 links even if they are similar but we dont call retrieveImage() function to avoid fill our database with same files (for simplicity)
          if (isset($thumbnail->type) && ($thumbnail->type == "mobile")) {
              $mobile_link = $thumbnail->urls[0];
          }
          if (isset($thumbnail->type) && ($thumbnail->type == "tablet")) {
              $tablet_link = $thumbnail->urls[0];
          }
        } else {
          $pc_link = $default_image;
          $mobile_link = $default_image;
          $tablet_link = $default_image;
        }
      }
    } else {
      $image_path = "default-avatar.png";
      $pc_link = $default_image;
      $mobile_link = $default_image;
      $tablet_link = $default_image;
    }
    $listing = Listing::create([ "name" => $name, "link" => $link, "image" => $image_path]);
    Atts::create(["listing_id" => $listing->id, "hair_color" => $haircolor, "ethnicity" => $ethnicity, "tattoos" => $tattoos, "piercings" => $piercings, "breastsize" => $breastsize, "breasttype" => $breasttype, "gender" => $gender, "orientation" => $orientation, "age" => $age]);
    Thumbnails::create(["listing_id" => $listing->id, "pc" => $pc_link, "mobile" => $mobile_link, "tablet" => $tablet_link]);
  }

})->purpose('Retrieve API Data')->daily();
