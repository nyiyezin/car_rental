<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $bookings = $this->bookingService->getAllBookings();
        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $booking = $this->bookingService->createBooking($data);
            return response()->json($booking, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id)
    {
        $booking = $this->bookingService->getBookingById($id);
        if (!$booking) {
            return response()->json(['message' => 'Cannot Found'], 404);
        };
        return response()->json($booking);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->all();
        try {
            $booking = $this->bookingService->updateBooking($id, $data);
            return response()->json($booking);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy(int $id)
    {
        $deleted = $this->bookingService->deleteBooking($id);
        return $deleted;
    }
}
