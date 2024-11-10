<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function create()
    {
        $token = Session::get('booking_token');
        return view('customer.create', ['token' => $token]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $customer = $this->customerService->createCustomer($data);
            Session::put('customer_id', $customer->id);
            $token = Session::get('booking_token');
            return redirect()->route('booking.create', ['token' => $token])
                ->with('success', 'Customer created successfully! Proceed to booking details.');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }
}
