<?php

namespace App\Repositories;

use App\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function getAllCustomers()
    {
        return Customer::all();
    }

    public function getCustomerByColumn(string $column, $value): Customer
    {
        return Customer::where($column, $value)->firstOrFail();
    }

    public function createCustomer(array $data)
    {
        $customer = new Customer();
        $customer->identification_num = $data['identification_num'];
        $customer->name = $data['name'];
        $customer->phone_number = $data['phone_number'];
        $customer->email = $data['email'];
        $customer->save();

        return $customer;
    }

    public function updateCustomer(int $id, array $data)
    {
        $customer = $this->getCustomerByColumn('id', $id);
        $customer->identification_num = $data['identification_num'];
        $customer->name = $data['name'];
        $customer->phone_number = $data['phone_number'];
        $customer->email = $data['email'];
        $customer->save();

        return $customer;
    }

    public function removeCustomer(int $id)
    {
        $customer = $this->getCustomerByColumn('id', $id);
        return $customer->delete();
    }

    public function restoreCustomer(int $id)
    {
        return Customer::withTrashed()->findOrFail($id)->restore();
    }
}
