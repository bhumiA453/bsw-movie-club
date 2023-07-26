<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class BookingController extends Controller
{
    public function get_all_booking()
    {
        $details = DB::table('booking as b')
        ->join('movie as m', 'b.m_id', '=', 'm.id')
        ->select('b.*', 'm.m_name')
        ->get();

        /*$booking = new Booking();
        $details = $booking->getDetails();*/
        return view('booking.view', ['details' => $details]);
        // echo '<pre>';print_r($details);exit();
    }
}
