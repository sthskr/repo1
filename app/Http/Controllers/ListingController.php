<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Atts;
use App\Models\Thumbnails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
  public function index(Request $request) {
    // We get the contents from table "listings" and pass it to view
    // Also we set paginator
    return view('listings', [
      'listings' => Listing::orderBy('id', 'ASC')->paginate(24)
    ]);
  }

  public function endpoint() {
    $exported_data = [];
    // We retrieve data by ascending order
    $items_listing = Listing::orderBy('id', 'ASC')->get();
    // We create our custom array with the data that we choose
    foreach($items_listing as $item) {
      $exported_data[] = ["name" => $item->name, "link" => $item->link, "image" => "storage/" . $item->image, "hairColor" => $item->atts->hair_color, "Ethnicity" => $item->atts->ethnicity, "Tattoos" => $item->atts->tattoos, "Piercings" => $item->atts->piercings, "Orientation" => $item->atts->orientation, "Age" => $item->atts->age, "Gender" => $item->atts->gender];
    }
    // We return the data in json format
    return Response::json($exported_data);
  }
}
