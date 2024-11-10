<?php

namespace App\Http\Controllers;

use App\Services\CarService;
use App\Services\DriverService;
use App\Services\LocationService;
use Illuminate\Support\Facades\Session;

class CreateBookingController extends Controller
{
    protected $carService;
    protected $locationService;
    protected $driverService;

    public function __construct(CarService $carService, LocationService $locationService, DriverService $driverService)
    {
        $this->carService = $carService;
        $this->locationService = $locationService;
        $this->driverService = $driverService;
    }

    public function __invoke()
    {
        $car = $this->carService->getCarById(Session::get('selected_car_id'));
        $locations = $this->locationService->getAllLocations();
        $availableDrivers = $this->driverService->getAvailableDrivers();
        return view('bookingCreate', compact('car', 'locations', 'availableDrivers'));
    }
}
