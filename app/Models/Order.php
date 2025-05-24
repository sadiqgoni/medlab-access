<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    
    /**
     * Get the services associated with this order.
     */
    public function getServiceDetailsFromData()
    {
        // Get service IDs from the details JSON field
        if (isset($this->details['service_ids']) && is_array($this->details['service_ids'])) {
            return Service::whereIn('id', $this->details['service_ids'])->get();
        }
        
        return collect();
    }
    
    /**
     * Get the primary service associated with this order (for backward compatibility).
     */
    public function service(): BelongsTo
    {
        // For backward compatibility with older code that expects a single service
        // This handles the case where an order has a direct service_id field or the first service from the array
        if (isset($this->details['service_ids']) && count($this->details['service_ids']) > 0) {
            $serviceId = $this->details['service_ids'][0];
            return $this->belongsTo(Service::class, 'service_id')->withDefault(function ($service, $order) use ($serviceId) {
                // If the service_id field doesn't exist, get the first service from details
                $actualService = Service::find($serviceId);
                if ($actualService) {
                    $service->fill($actualService->toArray());
                }
            });
        }
        
        return $this->belongsTo(Service::class, 'service_id');
    }
}
