<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class countries extends Model
{
    use HasFactory;

    // public function cities()
    // {
    //     return $this->hasMany(cities::class, 'country_code', 'iso2');
    // }

    // public function getNameAttribute()
    // {
    //     return $this->attributes['name'];
    // }

    // protected $fillable = ['name', 'iso2'];

    public function travel()
    {
        return $this->hasMany(TravelPackage::class);
    }
}
