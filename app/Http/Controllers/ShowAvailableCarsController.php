<?php

namespace App\Http\Controllers;

use App\Services\CarService;
use Illuminate\Http\Request;

class ShowAvailableCarsController extends Controller
{
    protected $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    public function __invoke(Request $request)
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
        $filterOptions = $this->carService->getFilterOptions();

        return view('car.index', compact('cars', 'filters', 'filterOptions'));
    }
}
