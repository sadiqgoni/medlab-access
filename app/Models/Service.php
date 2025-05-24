<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category',
        'price',
        'availability_status',
        'turnaround_time',
        'requirements',
        'notes',
        'status',
        'facility_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the facility that owns this service.
     */
    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    /**
     * Scope a query to only include services of a specific category.
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to only include available services.
     */
    public function scopeAvailable($query)
    {
        return $query->where('availability_status', 'available');
    }

    /**
     * Scope a query to only include approved services.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include pending services.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
