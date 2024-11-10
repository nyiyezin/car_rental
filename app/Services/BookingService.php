<?php

namespace App\Services;

use App\Repositories\Interfaces\BookingRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BookingService
{
    protected $bookingRepository;

    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function getAllBookings()
    {
        return $this->bookingRepository->getAllBookings();
    }

    public function getBookingById(int $id)
    {
        return $this->bookingRepository->getBookingByColumn('id', $id);
    }

    public function getBookingByBookingToken(string $token)
    {
        return $this->bookingRepository->getBookingByColumn('booking_token', $token);
    }

    public function createBooking(array $data)
    {
        $data['is_driver_included'] = $data['is_driver_included'] ?? false;
        $validator = Validator::make($data, [
            'rental_start_date' => 'required|date',
            'rental_end_date' => 'required|date|after:rental_start_time',
            'is_driver_included' => 'boolean',
            'customer_id' => 'required|exists:customers,id',
            'car_id' => 'required|exists:cars,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'payment_id' => 'required|exists:payments,id',
            'pickup_location_id' => 'required|exists:locations,id',
            'dropoff_location_id' => 'required|exists:locations,id',
        ]);

        $validator->sometimes('driver_id', 'required', function ($input) {
            return $input->is_driver_included;
        });

        $validator->after(function ($validator) use ($data) {
            if (isset($data['rental_start_ymd'], $data['rental_end_ymd'])) {
                $startDate = Carbon::createFromFormat('Y-m-d', $data['rental_start_ymd']);
                $endDate = Carbon::createFromFormat('Y-m-d', $data['rental_end_ymd']);
                if ($endDate->lessThanOrEqualTo($startDate)) {
                    $validator->errors()->add('rental_end_ymd', 'The rental end date must be after the rental start date.');
                }
            }
        });

        if ($validator->fails()) {
            dd($validator->errors());
            throw new ValidationException($validator);
        }

        $data['status'] = $data['status'] ?? 'pending';

        return $this->bookingRepository->createBooking($data);
    }

    public function updateBooking(int $id, array $data)
    {
        $validator = Validator::make($data, [
            'rental_start_time' => 'nullable|date|after_or_equal:today',
            'rental_end_time' => 'nullable|date|after:rental_start_time',
            'status' => 'nullable|in:pending,confirmed,cancelled,completed',
            'is_driver_included' => 'nullable|boolean',
            'car_id' => 'nullable|exists:cars,id',
            'customer_id' => 'nullable|exists:customers,id',
            'payment_id' => 'required|exists:payments,id',
            'pickup_location_id' => 'nullable|exists:locations,id',
            'dropoff_location_id' => 'nullable|exists:locations,id',
            'driver_id' => 'nullable|exists:drivers,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        if ($data['is_driver_included'] && !isset($data['driver_id'])) {
            throw new ValidationException(Validator::make(
                $data,
                ['driver_id' => 'required|exists:drivers,id']
            ));
        };

        if (!$data['is_driver_included'] && isset($data['driver_id'])) {
            $validator->after(function ($validator) {
                $validator->errors()->add('driver_id', 'Driver ID is required when driver is included.');
            });
            throw new ValidationException($validator);
        };

        return $this->bookingRepository->updateBooking($id, $data);
    }

    public function deleteBooking(int $id)
    {
        return $this->bookingRepository->deleteBooking($id);
    }

    public function restoreBooking(int $id)
    {
        return $this->bookingRepository->restoreBooking($id);
    }

    public function updateBookingStatus(Request $request, int $bookingId)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $this->bookingRepository->updateBookingStatus($bookingId, $request->input('status'));
    }

    public function getBookingsByCustomer(int $customerId)
    {
        return $this->bookingRepository->getBookingsByCustomer($customerId);
    }

    public function getBookingsByStatus(string $status)
    {
        return $this->bookingRepository->getBookingsByStatus($status);
    }
}
