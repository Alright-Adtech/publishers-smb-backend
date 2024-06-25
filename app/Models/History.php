<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
