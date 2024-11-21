<?php

namespace App\Http\Controllers\Api\V1;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        $customers = $this->customerService->getAllCustomers();
        return response()->json($customers);
    }

    public function store(Request $request)
    {
        $customer = $this->customerService->createCustomer($request->all());
        return response()->json($customer, 201);
    }

    public function show($id)
    {
        $customer = $this->customerService->getCustomerById($id);
        return response()->json($customer);
    }

    public function update(Request $request, $id)
    {
        $customer = $this->customerService->updateCustomer($id, $request->all());
        return response()->json($customer);
    }

    public function destroy($id)
    {
        $customer = $this->customerService->getCustomerById($id);
        $customer->delete();
        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
