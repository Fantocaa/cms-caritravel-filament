<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class Document extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $fillable = [
        'country',
        'info',
        'category'
    ];

    protected $casts = [
        'country' => 'array',
    ];

    public $translatable = [
        'info',
        'category'
    ];

    public function countries()
    {
        return $this->belongsTo(countries::class, 'id');
    }
}
