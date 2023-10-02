<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Section extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = [
        'title',
        'short_description',
        'slug',
    ];

    protected $fillable = [
        'type',
    ];

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function post(): HasMany
    {
        return $this->hasMany(Post::class, 'section_id', 'id');
    }
}
