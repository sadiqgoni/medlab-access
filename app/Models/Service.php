<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Import BelongsToMany

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'attributes',
        'is_active',
        'type', // Added type based on previous controller logic
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'attributes' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * The facilities that offer this service.
     */
    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'facility_service');
    }
}
