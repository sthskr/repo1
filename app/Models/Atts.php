<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Atts extends Model
{
  protected $fillable = ['listing_id', 'hair_color', 'ethnicity', 'tattoos', 'piercings', 'breastSize', 'breastType', 'gender', 'orientation', 'age'];

  // Relationship to User
  public function listing()
  {
      return $this->belongsTo(Listing::class, 'listing_id');
  }
}