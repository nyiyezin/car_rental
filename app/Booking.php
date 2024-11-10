<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Booking extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $casts = [
        'is_driver_included' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_token)) {
                $booking->booking_token = Str::random(32);
            }
            \Illuminate\Support\Facades\Session::put($booking->booking_token);
        });
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function pickupLocation()
    {
        return $this->belongsTo(Location::class, 'pickup_location_id');
    }

    public function dropoffLocation()
    {
        return $this->belongsTo(Location::class, 'dropoff_location_id');
    }
}
