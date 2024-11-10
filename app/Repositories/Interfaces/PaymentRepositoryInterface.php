<?php

namespace App\Repositories\Interfaces;

use App\Booking;
use App\Payment;

interface PaymentRepositoryInterface
{
    public function getAllPayments();

    public function getPaymentByColumn(string $column, $value): Payment;

    public function createPayment(array $data);

    public function updatePayment(int $id, array $data);

    public function removePayment(int $id);

    public function restorePayment(int $id);
}
