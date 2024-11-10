<?php

namespace App\Repositories\Interfaces;

use App\Location;

interface LocationRepositoryInterface
{
    public function getAllLocations();

    public function getLocationByColumn(string $column, $value): Location;

    public function createLocation(array $data);

    public function updateLocation(int $id, array $data);

    public function removeLocation(int $id);

    public function restoreLocation(int $id);
}
