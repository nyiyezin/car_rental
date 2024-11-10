<?php

namespace App\Http\Controllers;

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
        $filters['carAvailability'] = 'available';
        $cars = $this->carService->getAllCars($filters);
        $filtersOptions = $this->carService->getFilterOptions();

        return view('car.index', [
            'cars' => $cars,
            'filters' => $filters,
            'filterOptions' => $filtersOptions
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $car = $this->carService->createCar($data);
            return redirect()->route('cars.index')
                ->with('success', 'Car created successfully');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    public function show(string $registrationNumber)
    {
        $car = $this->carService->getCarByRegistrationNumber($registrationNumber);

        if (!$car) {
            return redirect()->route('cars.index')
                ->with('error', 'Car not found');
        }

        return view('car.show', ['car' => $car]);
    }

    public function update(Request $request, $registrationNumber)
    {
        $data = $request->all();

        try {
            $this->carService->updateCar($registrationNumber, $data);
            return redirect()->route('cars.index')
                ->with('success', 'Car updated successfully');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    public function destroy(string $registrationNumber)
    {
        $deleted = $this->carService->removeCar($registrationNumber);

        if ($deleted) {
            return redirect()->route('cars.index')
                ->with('success', 'Car deleted successfully');
        }

        return redirect()->route('cars.index')
            ->with('error', 'Failed to delete car');
    }
}
