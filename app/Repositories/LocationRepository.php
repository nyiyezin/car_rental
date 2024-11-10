<?php

namespace App\Repositories;

use App\Location;
use App\Repositories\Interfaces\LocationRepositoryInterface;

class LocationRepository implements LocationRepositoryInterface
{
    public function getAllLocations()
    {
        return Location::all();
    }

    public function getLocationByColumn(string $column, $value): Location
    {
        return Location::query()->where($column, $value)->firstOrFail();
    }

    public function createLocation(array $data)
    {
        $location = new Location();
        $location->address = $data['address'];
        $location->latitude = $data['latitude'];
        $location->longitude = $data['longitude'];
        $location->save();

        return $location;
    }

    public function updateLocation(int $id, array $data)
    {
        $location = $this->getLocationByColumn('id', $id);
        $location->address = $data['address'];
        $location->latitude = $data['latitude'];
        $location->longitude = $data['longitude'];
        $location->save();

        return $location;
    }

    public function removeLocation(int $id)
    {
        $location = $this->getLocationByColumn('id', $id);
        return $location->delete();
    }

    public function restoreLocation(int $id)
    {
        return Location::withTrashed()->findOrFail($id)->restore();
    }
}
