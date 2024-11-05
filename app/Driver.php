<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function cars()
    {
        return $this->belongsToMany(Car::class, 'driver_car_histories')
            ->withPivot(['driver_type']);
    }
}
