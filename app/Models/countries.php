<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class countries extends Model
{
    use HasFactory;

    public function travel()
    {
        return $this->hasMany(TravelPackage::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'id');
    }
}
