<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
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
