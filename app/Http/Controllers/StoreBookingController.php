<?php

namespace App\Http\Controllers;

use App\Services\BookingService;
use App\Services\CarService;
use App\Services\CustomerService;
use App\Services\DriverService;
use App\Services\PaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StoreBookingController extends Controller
{
    protected $customerService;
    protected $bookingService;
    protected $paymentService;
    protected $carService;
    protected $driverService;

    public function __construct(
        CustomerService $customerService,
        BookingService $bookingService,
        PaymentService $paymentService,
        CarService $carService,
        DriverService $driverService
    ) {
        $this->customerService = $customerService;
        $this->bookingService = $bookingService;
        $this->paymentService = $paymentService;
        $this->carService = $carService;
        $this->driverService = $driverService;
    }

    public function __invoke(Request $request)
    {
        $data = $request->all();
        $rentalPeriod = explode(' to ', $data['rental_period']);
        $rentalStartDate = Carbon::parse($rentalPeriod[0]);
        $rentalEndDate = Carbon::parse($rentalPeriod[1]);
        $duration = $rentalEndDate->diffInDays($rentalStartDate);
        $car = $this->carService->getCarById($data['car_id']);
        $estimatedPrice = $duration * $car->daily_rate;

        if (!empty($data['is_driver_included']) && !empty($data['driver_id'])) {
            $driver = $this->driverService->getDriverById($data['driver_id']);
            $driverDailyRate = $driver->daily_rate;
            $estimatedPrice += $duration * $driverDailyRate;
        }

        $taxAmount = $estimatedPrice * 0.055;
        $totalAmount = $estimatedPrice + $taxAmount;

        $customerData = [
            'identification_num' => $data['identification_num'],
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
        ];

        $customer = $this->customerService->createCustomer($customerData);

        $paymentData = [
            'payment_status' => 'pending',
            'total_amount' => $totalAmount,
            'tax_amount' => $taxAmount,
        ];

        $payment = $this->paymentService->createPayment($paymentData);

        $bookingData = [
            'rental_start_date' => $rentalStartDate,
            'rental_end_date' => $rentalEndDate,
            'status' => 'pending',
            'is_driver_included' => $data['is_driver_included'] ?? 0,
            'car_id' => $data['car_id'],
            'customer_id' => $customer->id,
            'driver_id' => ($data['is_driver_included'] ?? 0) ? $data['driver_id'] : null,
            'payment_id' => $payment->id,
            'pickup_location_id' => $data['pickup_location_id'],
            'dropoff_location_id' => $data['dropoff_location_id'],
        ];

        $booking = $this->bookingService->createBooking($bookingData);

        $bookingToken = $booking->booking_token;

        return view('thankYou', compact('bookingToken'));
    }
}
