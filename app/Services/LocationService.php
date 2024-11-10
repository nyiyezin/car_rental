<?php

namespace App\Services;

use App\Repositories\Interfaces\LocationRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LocationService
{
    protected $locationRepository;

    public function __construct(LocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function getAllLocations()
    {
        return $this->locationRepository->getAllLocations();
    }

    public function getLocationById(int $id)
    {
        return $this->locationRepository->getLocationByColumn('id', $id);
    }

    public function createLocation(array $data)
    {
        $validator = Validator::make($data, [
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->locationRepository->createLocation($data);
    }

    public function updateLocation(int $id, array $data)
    {
        $validator = Validator::make($data, [
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->locationRepository->updateLocation($id, $data);
    }

    public function removeLocation(int $id)
    {
        return $this->locationRepository->removeLocation($id);
    }

    public function restoreLocation(int $id)
    {
        return $this->locationRepository->restoreLocation($id);
    }
}
