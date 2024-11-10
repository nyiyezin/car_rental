<?php

namespace App\Repositories\Interfaces;

use App\Driver;
use Illuminate\Database\Eloquent\Collection;

interface DriverRepositoryInterface
{
    public function getAllDrivers(array $filters);

    public function getDriverByColumn(string $column, $value): Driver;

    public function createDriver(array $data);

    public function updateDriver(int $id, array $data);

    public function removeDriver(int $id);

    public function restoreDriver(int $id);

    public function getAvailableDrivers(): Collection;
}
