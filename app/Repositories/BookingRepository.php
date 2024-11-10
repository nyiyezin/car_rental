<?php

namespace App\Repositories;

use App\Booking;
use App\Car;
use App\Driver;
use Carbon\Carbon;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BookingRepository implements BookingRepositoryInterface
{
    public function getAllBookings()
    {
        return Booking::with(['car', 'customer', 'pickupLocation', 'dropoffLocation'])->get();
    }

    public function getBookingByColumn(string $column, $value): Booking
    {
        return Booking::query()
            ->where($column, $value)
            ->with(['car', 'customer', 'pickupLocation', 'dropoffLocation'])
            ->firstOrFail();
    }

    public function createBooking(array $data)
    {
        $booking = new Booking();
        $booking->car_id = $data['car_id'];
        $booking->status = $data['status'];
        $booking->rental_start_date = $data['rental_start_date'];
        $booking->rental_end_date = $data['rental_end_date'];
        $booking->status = $data['status'];
        $booking->is_driver_included = $data['is_driver_included'];
        $booking->payment_id = $data['payment_id'];
        $booking->payment()->associate($data['payment_id']);
        $booking->car()->associate($data['car_id']);
        $booking->customer()->associate($data['customer_id']);
        $booking->pickupLocation()->associate($data['pickup_location_id']);
        $booking->dropoffLocation()->associate($data['dropoff_location_id']);

        if ($data['is_driver_included'] && isset($data['driver_id'])) {
            $booking->driver()->associate($data['driver_id']);
        } else {
            $booking->driver_id = null;
        }

        $booking->save();

        return $booking;
    }

    public function updateBooking(int $id, array $data)
    {
        $booking = $this->getBookingByColumn('id', $id);
        $booking->rental_start_time = isset($data['rental_start_time']) ? Carbon::parse($data['rental_start_time']) : $booking->rental_start_time;
        $booking->rental_end_time = isset($data['rental_end_time']) ? Carbon::parse($data['rental_end_time']) : $booking->rental_end_time;
        $booking->total_amount = $data['total_amount'] ?? $booking->total_amount;
        $booking->status = $data['status'] ?? $booking->status;
        $booking->is_driver_included = $data['is_driver_included'] ?? $booking->is_driver_included;
        $booking->payment_id = $data['payment_id'] ?? $booking->payment_id;
        $booking->car_id = $data['car_id'] ?? $booking->car_id;
        $booking->customer_id = $data['customer_id'] ?? $booking->customer_id;
        $booking->pickup_location_id = $data['pickup_location_id'] ?? $booking->pickup_location_id;
        $booking->dropoff_location_id = $data['dropoff_location_id'] ?? $booking->dropoff_location_id;
        if (isset($data['is_driver_included']) && $data['is_driver_included'] && isset($data['driver_id'])) {
            $booking->driver_id = $data['driver_id'];
        } else {
            $booking->driver_id = null;
        }

        $booking->save();

        return $booking;
    }

    public function deleteBooking(int $id)
    {
        $booking = $this->getBookingByColumn('id', $id);
        return $booking->delete();
    }

    public function restoreBooking(int $id)
    {
        return Booking::withTrashed()->findOrFail($id)->restore();
    }

    public function updateBookingStatus(int $id, string $status)
    {
        $booking = $this->getBookingByColumn('id', $id);
        $booking->status = $status;
        $booking->save();
        return $booking;
    }

    public function getBookingsByStatus(string $status): Collection
    {
        return Booking::query()->where('status', $status)->get();
    }

    public function getBookingsByCustomer(int $customerId): Collection
    {
        return Booking::query()->where('customer_id', $customerId)->get();
    }
}
