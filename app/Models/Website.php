<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Website extends Model
{
    use HasFactory;
    protected $fillable = [
      'url',
      'state',
      'city',
      'views',
  ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(History::class);
    }
    
    public function websiteSegment(): HasOne
    {
        return $this->hasOne(WebsiteSegment::class);
    }
}
