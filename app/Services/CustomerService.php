<?php

namespace App\Services;

use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAllCustomers()
    {
        return $this->customerRepository->getAllCustomers();
    }

    public function createCustomer(array $data)
    {
        $validator = Validator::make($data, [
            'identification_num' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->customerRepository->createCustomer($data);
    }

    public function getCustomerById(int $id)
    {
        return $this->customerRepository->getCustomerByColumn('id', $id);
    }

    public function updateCustomer(int $id, array $data)
    {
        $validator = Validator::make($data, [
            'identification_num' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->customerRepository->updateCustomer($id, $data);
    }

    public function removeCustomer(int $id)
    {
        return $this->customerRepository->removeCustomer($id);
    }

    public function restoreCustomer(int $id)
    {
        return $this->customerRepository->restoreCustomer($id);
    }
}
