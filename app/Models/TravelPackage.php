<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class TravelPackage extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'countries' => 'array',
        'cities' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'image_name' => 'array',
    ];

    public function getCountryIdsAttribute()
    {
        return isset($this->attributes['countries']) ? json_decode($this->attributes['countries'], true) : [];
    }

    public function setCountryIdsAttribute($value)
    {
        $this->attributes['countries'] = json_encode($value);
    }

    public function getCityIdsAttribute()
    {
        return isset($this->attributes['cities']) ? json_decode($this->attributes['cities'], true) : [];
    }

    public function setCityIdsAttribute($value)
    {
        $this->attributes['cities'] = json_encode($value);
    }

    // Old
    public function country()
    {
        return $this->belongsTo(countries::class, 'countries');
    }

    public function city()
    {
        return $this->belongsTo(cities::class, 'cities');
    }

    protected static function booted(): void
    {
        self::deleted(function (TravelPackage $project) {
            // Storage::disk('public')->delete($project->image_name);
            Storage::delete($project->image_name);
        });
    }

    protected $fillable = [
        'countries',
        'cities',
        'traveler',
        'duration',
        'duration_night',

        'start_date',
        'end_date',
        'image_name',

        'date',
        'general_info',
        'travel_schedule',
        'additional_info',
        'title',
        'author',
        'price',
    ];
}
