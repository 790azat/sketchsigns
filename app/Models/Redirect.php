<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $guarded = [];

    /** Store paths as "/some/path": leading slash, no trailing slash, no domain. */
    public static function normalize(?string $path): string
    {
        $path = (string) parse_url(trim((string) $path), PHP_URL_PATH);

        return '/'.trim(strtolower($path), '/');
    }

    protected function fromPath(): Attribute
    {
        return Attribute::set(fn ($value) => static::normalize($value));
    }
}
