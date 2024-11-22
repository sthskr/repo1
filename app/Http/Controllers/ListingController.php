<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Atts;
use App\Models\Thumbnails;
use Illuminate\Http\Request;
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
}
