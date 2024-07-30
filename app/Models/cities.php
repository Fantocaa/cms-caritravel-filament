<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cities extends Model
{
    use HasFactory;

    // public function country()
    // {
    //     return $this->belongsTo(countries::class, 'country_code', 'iso2');
    // }

    // public function getNameAttribute()
    // {
    //     return $this->attributes['name'];
    // }

    // protected $fillable = ['name', 'country_code'];

    public function travel()
    {
        return $this->hasMany(TravelPackage::class);
    }
}
