<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Listing;
use App\Models\Atts;
use App\Models\Thumbnails;
use Illuminate\Support\Facades\Schedule;

Schedule::command('retrieve-api-data')->daily();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('retrieve-api-data', function () {
  // The first check we make is to avoid to fill our database with a lot of content
  // This is because of limited resources, in a production environment we would remove this check
  // Also we will not store all data from url, for simplicity we will use the necessary (name, link, image, attributes..)
  if (Listing::count() < 50) {
    // We set no memory limit during the retrieve function
    ini_set('memory_limit', -1);
    $apiUrl = "https://ph-c3fuhehkfqh6huc0.z01.azurefd.net/feed_pornstars.json";
    $response = Http::get($apiUrl);
    // We remove characters that will break json validation
    $result = str_replace('\xF0', '', $response->getBody()->getContents());
    $data = json_decode($result);
    // We unset variables to release memory
    unset($result);
    $all_items = $data->items;
    unset($data);
    // We choose to store only limited number of items
    for ($i = 0; $i <= 50; $i++) {
        $items[] = $all_items[$i];
    }
    unset($all_items);
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
      if (isset($item->thumbnails)) {
        foreach($item->thumbnails as $thumbnail) {
          if(isset($thumbnail->type)) {
            if ($thumbnail->type == "pc") {
              // We will use only the "pc link" for simplicity
              // We could download 3 images for every item and store in different folders
              // and in blade template we could use in html srcset with the 3 images for responsive screens
              $pc_link = $thumbnail->urls[0];
              // Download image from url and store at storage/app/public/assets
              // We use curl instead of file_get_contents()
              $ch = curl_init($pc_link);
              // Useragent headers
              curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              // We set this option to true so if the image is through riderected link, we will retrieve as well
              curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
              $retrieve_image = curl_exec($ch);
              // We can check for image size if we want
              $image_size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
              // We set uniq id for filename so even with the same name, we will not have conflicts
              $image_filename = uniqid() . '.jpg';
              $image_path = 'assets/' . $image_filename;
              curl_close($ch);
              Storage::disk('public')->put('assets/' . $image_filename, $retrieve_image);
            }
            // We keep store other 2 links even if they are similar
            if ($thumbnail->type == "mobile") {
                $mobile_link = $thumbnail->urls[0];
            }
            if ($thumbnail->type == "tablet") {
                $tablet_link = $thumbnail->urls[0];
            }
          }
        }
      }
      Listing::create([ "name" => $name, "link" => $link, "image" => $image_path]);
      Atts::create(["listing_id" => $listing->id, "hair_color" => $haircolor, "ethnicity" => $ethnicity, "tattoos" => $tattoos, "piercings" => $piercings, "breastsize" => $breastsize, "breasttype" => $breasttype, "gender" => $gender, "orientation" => $orientation, "age" => $age]);
      Thumbnails::create(["listing_id" => $listing->id, "pc" => $pc_link, "mobile" => $mobile_link, "tablet" => $tablet_link]);
    }
  }

})->purpose('Retrieve API Data')->daily();
