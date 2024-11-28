<?php

namespace App\Repositories;

use App\Car;
use App\Image;
use App\Repositories\Interfaces\CarRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class CarRepository implements CarRepositoryInterface
{
    public function getAllCars(array $filters = [])
    {
        return Car::query()->with('images')->filter($filters)->paginate(9);
    }

    public function getCarByColumn(string $column, $value): Car
    {
        return Car::query()->where($column, $value)->with('images')->firstOrFail();
    }

    private function handleImages($car, array $images)
    {
        foreach ($images as $uploadedImage) {
            $filePath = $uploadedImage->store('images', 'public');
            $image = new Image();
            $image->car_id = $car->id;
            $image->file_path = $filePath;
            $image->save();
        }
    }

    public function createCar(array $data)
    {
        $car = new Car();
        $car->registration_number = $data['registration_number'];
        $car->model_name = $data['model_name'];
        $car->model_year = $data['model_year'];
        $car->total_kilometers = $data['total_kilometers'];
        $car->luggage_capacity = $data['luggage_capacity'];
        $car->passenger_capacity = $data['passenger_capacity'];
        $car->daily_rate = $data['daily_rate'];
        $car->late_fee_per_hour = $data['late_fee_per_hour'];
        $car->is_available = $data['is_available'] ?? false;
        $car->rate_per_kilometer = $data['rate_per_kilometer'] ?? null;
        $car->save();

        if (!empty($data['images']) && is_array($data['images'])) {
            $this->handleImages($car, $data['images']);
        }

        return $car->load('images');
    }

    public function updateCar(int $id, array $data)
    {
        $car = $this->getCarByColumn('id', $id);

        $car->model_name = $data['model_name'];
        $car->model_year = $data['model_year'];
        $car->total_kilometers = $data['total_kilometers'];
        $car->luggage_capacity = $data['luggage_capacity'];
        $car->passenger_capacity = $data['passenger_capacity'];
        $car->daily_rate = $data['daily_rate'];
        $car->late_fee_per_hour = $data['late_fee_per_hour'];
        $car->is_available = $data['is_available'] ?? false;
        $car->rate_per_kilometer = $data['rate_per_kilometer'] ?? null;
        $car->save();

        if (!empty($data['removed_image_ids'])) {
            $removedImageIds = json_decode($data['removed_image_ids'], true);
            $car->images()->whereIn('id', $removedImageIds)->each(function ($image) {
                Storage::disk('public')->delete($image->file_path);
                $image->delete();
            });
        }

        if (!empty($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $uploadedImage) {
                if ($uploadedImage instanceof \Illuminate\Http\UploadedFile) {
                    $filePath = $uploadedImage->store('images', 'public');
                    $image = new Image();
                    $image->car_id = $car->id;
                    $image->file_path = $filePath;
                    $image->save();
                }
            }
        }

        return $car->load('images');
    }

    public function removeCar(int $id)
    {
        $car = $this->getCarByColumn('id', $id);
        return $car->delete();
    }

    public function restoreCar(int $id)
    {
        return Car::withTrashed()->findOrFail($id)->restore();
    }

    public function getFilterOptions()
    {
        return [
            'model_years' => Car::select('model_year')->distinct()->pluck('model_year')->sortDesc(),
            'luggage_capacities' => Car::select('luggage_capacity')->distinct()->pluck('luggage_capacity')->sortDesc(),
            'passenger_capacities' => Car::select('passenger_capacity')->distinct()->pluck('passenger_capacity')->sortDesc(),
        ];
    }

    public function updateAvailabilityStatus(int $id, bool $isAvailable)
    {
        $car = $this->getCarByColumn('id', $id);
        $car->is_available = $isAvailable;
        $car->save();

        return $car;
    }
}
