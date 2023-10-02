<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'name',
    ];

    protected $appends = [
        'full_image',
    ];

    protected function fullImage(): Attribute
    {
        return Attribute::make(
            get: fn () => url('/').$this->path,
        );
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
