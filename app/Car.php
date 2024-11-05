<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public function drivers()
    {
        return $this
            ->belongsToMany(Driver::class, 'driver_car_histories')
            ->withPivot(['driver_type']);
    }
}
