<?php

namespace App\Http\Controllers;

use App\Car;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StartBookingController
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function __invoke(Request $request)
    {
        $car = Car::findOrFail($request->input('car_id'));
        Session::put('selected_car_id', $car->id);
        return redirect()->route('createBooking');
    }
}
