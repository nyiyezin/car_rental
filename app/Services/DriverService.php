<?php

namespace App\Services;

use App\Repositories\Interfaces\DriverRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DriverService
{
    protected $driverRepository;

    public function __construct(DriverRepositoryInterface $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    public function getAllDrivers(array $filters)
    {
        return $this->driverRepository->getAllDrivers($filters);
    }

    public function getDriverById(int $id)
    {
        return $this->driverRepository->getDriverByColumn('id', $id);
    }

    public function getDriverByLicenseNumber(string $licenseNumber)
    {
        return $this->driverRepository->getDriverByColumn('license_number', $licenseNumber);
    }

    public function createDriver(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'daily_rate' => 'required|numeric|min:0',
            'license_number' => 'required|string|max:255|unique:drivers,license_number',
            'phone_number' => 'required|string|max:255',
            'is_available' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->driverRepository->createDriver($data);
    }

    public function updateDriver(int $id, array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'daily_rate' => 'required|numeric|min:0',
            'license_number' => 'required|string|max:255|unique:drivers,license_number,' . $id,
            'phone_number' => 'required|string|max:255',
            'is_available' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->driverRepository->updateDriver($id, $data);
    }

    public function deleteDriver(int $id)
    {
        return $this->driverRepository->removeDriver($id);
    }

    public function restoreDriver(int $id)
    {
        return $this->driverRepository->restoreDriver($id);
    }

    public function getAvailableDrivers()
    {
        return $this->driverRepository->getAvailableDrivers();
    }
}
