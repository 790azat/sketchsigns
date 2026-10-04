<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Variation extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['options' => 'array'];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /** @param array<string, string> $selected attribute name => term slug */
    public function matches(array $selected): bool
    {
        foreach ($this->options as $name => $value) {
            if ($value !== '' && ($selected[$name] ?? null) !== $value) {
                return false;
            }
        }

        return true;
    }
}
