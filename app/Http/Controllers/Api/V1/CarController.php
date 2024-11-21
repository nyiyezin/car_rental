<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\CarService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CarController extends Controller
{
    protected $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    public function index(Request $request)
    {
        $filters = collect($request->only([
            'carModelName',
            'carModelYear',
            'luggageCapacity',
            'passengerCapacity',
            'dailyRate',
            'lateFee',
            'ratePerKilometer',
            'carAvailability'
        ]))
            ->filter(function ($value) {
                return $value !== null && $value !== '' && $value !== 0;
            })
            ->toArray();

        $filters['carAvailability'] = $filters['carAvailability'] ?? 'available';

        try {
            $cars = $this->carService->getAllCars($filters);
            return response()->json($cars);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch cars', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $car = $this->carService->createCar($data);
            return response()->json($car, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id)
    {
        $car = $this->carService->getCarById($id);
        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        return response()->json($car);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        try {
            $car = $this->carService->updateCar($id, $data);
            return response()->json($car);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id)
    {
        $deleted = $this->carService->removeCar($id);
        return $deleted;
    }
}
