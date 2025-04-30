<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'consumer_id',
        'facility_id',
        'biker_id',
        'order_type',
        'details',
        'status',
        'pickup_address',
        'delivery_address',
        'pickup_scheduled_time',
        'delivery_scheduled_time',
        'actual_pickup_time',
        'actual_delivery_time',
        'payment_status',
        'payment_method',
        'payment_gateway_ref',
        'total_amount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'details' => 'array',
        'total_amount' => 'decimal:2',
        'pickup_scheduled_time' => 'datetime',
        'delivery_scheduled_time' => 'datetime',
        'actual_pickup_time' => 'datetime',
        'actual_delivery_time' => 'datetime',
    ];

    /**
     * Get the consumer associated with the order.
     */
    public function consumer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'consumer_id');
    }

    /**
     * Get the facility associated with the order.
     */
    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    /**
     * Get the biker assigned to the order.
     */
    public function biker(): BelongsTo
    {
        // Note: biker_id references the users table
        return $this->belongsTo(User::class, 'biker_id');
    }
}
