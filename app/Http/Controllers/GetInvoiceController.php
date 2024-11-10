<?php

namespace App\Http\Controllers;

use App\Services\BookingService;
use App\Services\PaymentService;

class GetInvoiceController extends Controller
{
    protected $bookingService;
    protected $paymentService;

    public function __construct(BookingService $bookingService, PaymentService $paymentService)
    {
        $this->bookingService = $bookingService;
        $this->paymentService = $paymentService;
    }

    public function __invoke(string $bookingToken)
    {
        $booking = $this->bookingService->getBookingByBookingToken($bookingToken);
        return view('showInvoice', compact('booking'));
    }
}
