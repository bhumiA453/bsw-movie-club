<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class BookingController extends Controller
{
    public function get_all_booking()
    {
        $booking = new Booking();
        $details = $booking->getDetails();
        return view('booking.view', ['details' => $details]);
        // echo '<pre>';print_r($details);exit();
    }
}
