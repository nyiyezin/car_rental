<?php

namespace App\Http\Controllers;

use App\Services\BookingService;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;

class DownloadInvoiceController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function __invoke(string $bookingToken)
    {
        $booking = $this->bookingService->getBookingByBookingToken($bookingToken);
        $pdf = PDF::loadView('downloadInvoice', compact('booking'));
        return $pdf->download('Invoice_' . $booking->booking_token . '.pdf');
    }
}
