<?php

namespace App\Repositories;

use App\Driver;
use App\Repositories\Interfaces\DriverRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DriverRepository implements DriverRepositoryInterface
{
    public function getAllDrivers(array $filters)
    {
        return Driver::query()->filter($filters)->get();
    }

    public function getDriverByColumn(string $column, $value): Driver
    {
        return Driver::query()->where($column, $value)->firstOrFail();
    }

    public function createDriver(array $data)
    {
        $driver = new Driver();
        $driver->name = $data['name'];
        $driver->daily_rate = $data['daily_rate'];
        $driver->license_number = $data['license_number'];
        $driver->phone_number = $data['phone_number'];
        $driver->is_available = $data['is_available'];
        $driver->save();

        return $driver;
    }

    public function updateDriver(int $id, array $data)
    {
        $driver = $this->getDriverByColumn('license_number', $id);
        $driver->name = $data['name'];
        $driver->daily_rate = $data['daily_rate'];
        $driver->phone_number = $data['phone_number'];
        $driver->is_available = $data['is_available'];
        $driver->save();

        return $driver;
    }

    public function removeDriver(int $id)
    {
        $driver = $this->getDriverByColumn('license_number', $id);
        return $driver->delete();
    }

    public function restoreDriver(int $id)
    {
        return Driver::withTrashed()->findOrFail($id)->restore();
    }

    public function getAvailableDrivers(): Collection
    {
        return Driver::query()->where('is_available', true)->get();
    }
}
