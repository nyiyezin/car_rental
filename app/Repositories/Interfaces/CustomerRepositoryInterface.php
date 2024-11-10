<?php

namespace App\Repositories\Interfaces;

use App\Customer;

interface CustomerRepositoryInterface
{
    public function getAllCustomers();

    public function getCustomerByColumn(string $column, $value): Customer;

    public function createCustomer(array $data);

    public function updateCustomer(int $id, array $data);

    public function removeCustomer(int $id);

    public function restoreCustomer(int $id);
}
