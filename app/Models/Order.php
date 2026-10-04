<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const STATUSES = ['new' => 'New', 'in_progress' => 'In progress', 'shipped' => 'Shipped', 'done' => 'Done', 'cancelled' => 'Cancelled'];

    protected $guarded = [];

    protected function casts(): array
    {
        return ['items' => 'array'];
    }

    /** Cart lines with their chosen options as one readable string. */
    protected function lines(): Attribute
    {
        return Attribute::get(fn () => collect($this->items)->map(fn (array $item) => $item + [
            'options_text' => collect($item['options'] ?? [])->map(fn ($v, $k) => "$k: $v")->implode(' · '),
        ])->all());
    }
}
