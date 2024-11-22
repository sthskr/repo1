<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Thumbnails extends Model
{
  protected $fillable = ['listing_id', 'pc', 'mobile', 'tablet'];

  // Relationship to User
  public function listing()
  {
      return $this->belongsTo(Listing::class, 'listing_id');
  }
}