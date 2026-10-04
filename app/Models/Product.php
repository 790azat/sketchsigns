<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'options' => 'array',
            'in_stock' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(Variation::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** Option groups as [{name, terms: [{slug, name}]}]. */
    public function optionGroups(): array
    {
        return $this->options ?? [];
    }

    public function summary(): string
    {
        return Str::limit(trim(html_entity_decode(strip_tags((string) $this->short_description), ENT_QUOTES | ENT_HTML5)), 140);
    }

    public function findVariation(array $selected): ?Variation
    {
        return $this->variations->first(fn (Variation $v) => $v->matches($selected));
    }
}
