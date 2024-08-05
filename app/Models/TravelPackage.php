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
        // 'title',
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
        'yt_links',
        'thumb_img',

        'date',
        'general_info',
        'travel_schedule',
        'additional_info',
        'title',
        'author',
        'price',
    ];

    // Relasi ke model Country
    public function country()
    {
        return $this->belongsTo(countries::class, 'countries', 'iso2');
    }

    // Relasi ke model City
    public function city()
    {
        return $this->belongsTo(cities::class, 'cities', 'id');
    }

    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author');
    }

    protected static function booted(): void
    {
        self::deleted(function (TravelPackage $project) {
            Storage::delete($project->image_name);
        });
    }
}
