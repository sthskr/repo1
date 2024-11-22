<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Listing extends Model
{
  protected $fillable = ['listing_id', 'name', 'link', 'image'];

  // Relationship with Listings
  public function atts()
  {
      return $this->hasOne(Atts::class, 'listing_id');
  }

  // Relationship with Thumbnails
  public function thumbnails()
  {
      return $this->hasOne(Thumbnails::class, 'listing_id');
  }
}