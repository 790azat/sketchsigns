<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    public const STATUSES = ['new' => 'New', 'quoted' => 'Quoted', 'won' => 'Won', 'lost' => 'Lost'];

    protected $guarded = [];

    protected function casts(): array
    {
        return ['needed_by' => 'date'];
    }
}
