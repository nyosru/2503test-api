<?php

namespace App\Services;

use App\Contracts\BookingServiceInterface;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Collection;

class BookingService implements BookingServiceInterface
{
    public function getAllBookings(): Collection
    {
        return Booking::all();
    }

    public function createBooking(array $data): Booking
    {
        return Booking::create($data);
    }
}
