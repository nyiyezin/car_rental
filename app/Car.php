<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

class Car extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function scopeFilter($query, $filters)
    {
        if (!empty($filters['carModelName'])) {
            $query->where('model_name', 'like', '%' . $filters['carModelName'] . '%');
        }

        if (!empty($filters['carModelYear'])) {
            $query->where('model_year', $filters['carModelYear']);
        }

        if (!empty($filters['luggageCapacity'])) {
            $query->where('luggage_capacity', $filters['luggageCapacity']);
        }

        if (!empty($filters['passengerCapacity'])) {
            $query->where('passenger_capacity', $filters['passengerCapacity']);
        }

        if (!empty($filters['dailyRate'])) {
            $query->where('daily_rate', '<=', $filters['dailyRate']);
        }

        if (!empty($filters['lateFee'])) {
            $query->where('late_fee_per_hour', '<=', $filters['lateFee']);
        }

        if (!empty($filters['ratePerKilometer'])) {
            $query->where('rate_per_kilometer', '<=', $filters['ratePerKilometer']);
        }

        if (!empty($filters['carAvailability']) && $filters['carAvailability'] == 'available') {
            $query->where('is_available', true);
        }

        return $query;
    }

    public function drivers()
    {
        return $this
            ->belongsToMany(Driver::class, 'driver_car_histories')
            ->withPivot(['driver_type']);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
