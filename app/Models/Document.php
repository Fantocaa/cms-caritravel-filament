<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Document extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $fillable = [
        'country',
        'info'
    ];

    public array $translatable = [
        'info',
    ];

    public function countries()
    {
        return $this->belongsTo(countries::class, 'id');
    }
}
