<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSegment extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
  ];
}
