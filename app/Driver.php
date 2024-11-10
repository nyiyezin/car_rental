<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'driver_car_histories')
            ->withPivot(['driver_type']);
    }
}
