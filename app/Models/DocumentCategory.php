<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class DocumentCategory extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['category', 'info'];

    public array $translatable = ['info', 'category'];

    protected $casts = [
        'info' => 'array',
        'category' => 'array',
    ];

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'document_category');
    }
}
