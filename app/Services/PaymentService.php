<?php

namespace App\Services;

use App\Booking;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PaymentService
{
    protected $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function getAllPayments()
    {
        return $this->paymentRepository->getAllPayments();
    }

    public function getPaymentById(int $id)
    {
        return $this->paymentRepository->getPaymentByColumn('id', $id);
    }

    public function createPayment(array $data)
    {
        $validator = Validator::make($data, [
            'payment_status' => 'required|string|max:100',
            'total_amount' => 'required|numeric',
            'tax_amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->paymentRepository->createPayment($data);
    }

    public function updatePayment(int $id, array $data)
    {
        $validator = Validator::make($data, [
            'payment_status' => 'required|string|max:100',
            'total_amount' => 'required|numeric',
            'tax_amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->paymentRepository->updatePayment($id, $data);
    }

    public function removePayment(int $id)
    {
        return $this->paymentRepository->removePayment($id);
    }

    public function restorePayment(int $id)
    {
        return $this->paymentRepository->restorePayment($id);
    }
}
