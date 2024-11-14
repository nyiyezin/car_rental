<?php

namespace App\Http\Controllers\Admin;

use App\Car;
use App\Http\Controllers\Controller;
use App\Services\BookingService;
use App\Services\CarService;
use App\Services\CustomerService;
use App\Services\LocationService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    protected $carService;
    protected $customerService;
    protected $bookingService;
    protected $paymentService;
    protected $locationService;

    public function __construct(
        CarService $carService,
        CustomerService $customerService,
        BookingService $bookingService,
        PaymentService $paymentService,
        LocationService $locationService
    ) {
        $this->carService = $carService;
        $this->customerService = $customerService;
        $this->bookingService = $bookingService;
        $this->paymentService = $paymentService;
        $this->locationService = $locationService;
    }

    public function __invoke()
    {
        $cars = Car::all();
        $bookings = $this->bookingService->getAllBookings();
        $payments = $this->paymentService->getAllPayments();
        $customers = $this->customerService->getAllCustomers();
        return view('admin.dashboard', compact('cars', 'bookings', 'payments', 'customers'));
    }
}
