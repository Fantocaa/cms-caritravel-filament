<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class TravelPackage extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $casts = [
        'countries' => 'array',
        'cities' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'image_name' => 'array',
    ];

    public array $translatable = [
        'title',
        'general_info',
        'travel_schedule',
        'additional_info'
    ];

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

    public function countries()
    {
        return $this->hasMany(countries::class, 'countries');
    }

    public function cities()
    {
        return $this->hasMany(cities::class, 'cities');
    }

    // public function countries()
    // {
    //     return $this->belongsToMany(countries::class);
    // }

    // public function cities()
    // {
    //     return $this->belongsToMany(cities::class);
    // }

    // public function setCountriesAttribute($value)
    // {
    //     // Ambil kode ISO-2 negara berdasarkan nama negara
    //     $iso2 = countries::where('iso2', $value)->value('name');
    //     $this->attributes['countries'] = $iso2;
    // }

    // public function setCitiesAttribute($value)
    // {
    //     // Ambil ID kota berdasarkan nama kota
    //     $cityId = cities::where('id', $value)->value('name');
    //     $this->attributes['cities'] = $cityId;
    // }

    protected static function booted(): void
    {
        self::deleted(function (TravelPackage $project) {
            Storage::delete($project->image_name);
        });
    }
}
