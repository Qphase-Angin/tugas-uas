<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'metadata',
        'price',
        'image',
        'category_id',
    ];

    /**
     * Cast attributes to proper types.
     * Ensure metadata array is stored as JSON in the database.
     */
    protected $casts = [
        'metadata' => 'array',
        'price' => 'decimal:2',
    ];
}
