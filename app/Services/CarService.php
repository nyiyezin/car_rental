<?php

namespace App\Services;

use App\Repositories\Interfaces\CarRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CarService
{
    protected $carRepository;

    public function __construct(CarRepositoryInterface $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function getAllCars(array $filters)
    {
        return $this->carRepository->getAllCars($filters);
    }

    public function getCarById(int $id)
    {
        return $this->carRepository->getCarByColumn('id', $id);
    }

    public function getCarByRegistrationNumber(string $registrationNumber)
    {
        return $this->carRepository->getCarByColumn('registration_number', $registrationNumber);
    }

    public function createCar(array $data)
    {
        $validator = Validator::make($data, [
            'registration_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cars', 'registration_number'),
            ],
            'model_name' => 'required|string|max:255',
            'model_year' => 'required|integer|between:1900,2100',
            'total_kilometers' => 'required|numeric|min:0',
            'luggage_capacity' => 'required|integer|min:0',
            'passenger_capacity' => 'required|integer|min:1',
            'daily_rate' => 'required|integer|min:1',
            'late_fee_per_hour' => 'required|integer|min:0',
            'is_available' => 'required|boolean',
            'rate_per_kilometer' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->carRepository->createCar($data);
    }

    public function updateCar(int $id, array $data)
    {
        $validator = Validator::make($data, [
            'model_name' => 'required|string|max:255',
            'model_year' => 'required|integer|between:1900,2100',
            'total_kilometers' => 'required|numeric|min:0',
            'luggage_capacity' => 'required|integer|min:0',
            'passenger_capacity' => 'required|integer|min:1',
            'daily_rate' => 'required|integer|min:1',
            'late_fee_per_hour' => 'required|integer|min:0',
            'is_available' => 'required|boolean',
            'rate_per_kilometer' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->carRepository->updateCar($id, $data);
    }

    public function removeCar(int $id)
    {
        return $this->carRepository->removeCar($id);
    }

    public function restoreCar(int $id)
    {
        return $this->carRepository->restoreCar($id);
    }

    public function getFilterOptions()
    {
        return $this->carRepository->getFilterOptions();
    }

    public function updateAvailabilityStatus($request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'is_available' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->carRepository->updateAvailabilityStatus($id, $request->input('is_available'));
    }
}
