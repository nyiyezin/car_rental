<?php

namespace App\Http\Controllers;

use App\Services\BookingService;
use App\Services\DriverService;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    protected $bookingService;
    protected $driverService;
    protected $locationService;

    public function __construct(BookingService $bookingService, DriverService $driverService, LocationService $locationService)
    {
        $this->bookingService = $bookingService;
        $this->driverService = $driverService;
        $this->locationService = $locationService;
    }

    public function create(string $token)
    {
        if (!Session::has('selected_car_id') || !Session::has('customer_id')) {
            return redirect()->route('cars.index')->withErrors('Booking session expired, please start again.');
        }
        $carId = Session::get('selected_car_id');
        $customerId = Session::get('customer_id');
        $locations = $this->locationService->getAllLocations();
        $availableDrivers = $this->driverService->getAvailableDrivers();
        return view('booking.create', [
            'token' => $token,
            'carId' => $carId,
            'customerId' => $customerId,
            'locations' => $locations,
            'availableDrivers' => $availableDrivers,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $this->bookingService->createBooking($data);
            return redirect()->route(
                'payment.create',
                ['token' => $data['token']]
            )
                ->with('success', 'Booking created successfully. Proceed to payment page!');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }
}
