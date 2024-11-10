<?php

namespace App\Repositories\Interfaces;

use App\Booking;
use Illuminate\Database\Eloquent\Collection;

interface BookingRepositoryInterface
{
    public function getAllBookings();

    public function getBookingByColumn(string $column, $value): Booking;

    public function createBooking(array $data);

    public function updateBooking(int $id, array $data);

    public function deleteBooking(int $id);

    public function restoreBooking(int $id);

    public function updateBookingStatus(int $bookingId, string $status);

    public function getBookingsByStatus(string $status): Collection;

    public function getBookingsByCustomer(int $customerId): Collection;
}
