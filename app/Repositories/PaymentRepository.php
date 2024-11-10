<?php

namespace App\Repositories;

use App\Booking;
use App\Payment;
use App\Repositories\Interfaces\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function getAllPayments()
    {
        return Payment::all();
    }

    public function getPaymentByColumn(string $column, $value): Payment
    {
        return Payment::query()->where($column, $value)->firstOrFail();
    }

    public function createPayment(array $data)
    {
        $payment = new Payment();
        $payment->payment_status = $data['payment_status'];
        $payment->total_amount = $data['total_amount'];
        $payment->tax_amount = $data['tax_amount'];
        $payment->save();

        return $payment;
    }

    public function updatePayment(int $id, array $data)
    {
        $payment = $this->getPaymentByColumn('id', $id);
        $payment->payment_status = $data['payment_status'];
        $payment->total_amount = $data['total_amount'];
        $payment->tax_amount = $data['tax_amount'];
        $payment->save();

        return $payment;
    }

    public function removePayment(int $id)
    {
        $payment = $this->getPaymentByColumn('id', $id);
        return $payment->delete();
    }

    public function restorePayment(int $id)
    {
        return Payment::withTrashed()->findOrFail($id)->restore();
    }
}
