<?php

namespace App\Repositories\Interfaces;

use App\Car;

interface CarRepositoryInterface
{
    public function getAllCars(array $filters);

    public function getCarByColumn(string $column, $value): Car;

    public function createCar(array $data);

    public function updateCar(int $id, array $data);

    public function removeCar(int $id);

    public function restoreCar(int $id);

    public function getFilterOptions();

    public function updateAvailabilityStatus(int $id, bool $isAvailable);
}
