<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Seating;
use App\Models\Booking;
use Carbon\Carbon;
use Session;

class FrontendController extends Controller
{
    public function get_movie()
    {
        $today = Carbon::today();
        $toDate = $today->copy()->addWeek();
        $query = Movie::query();

        $query->whereDate('date', '>=', $today->toDateString())
            ->whereDate('date', '<=', $toDate->toDateString());
        $query->where('is_active', 1);
        $items = $query->get();
        return view('home',compact('items'));
        // echo '<pre>';print_r($items);exit();
    }

    public function get_seats(Request $request)
    {
        // $movie_data['s_count'] = Session::get('seats_count');
        $movie_data['m_id'] = Session::get('movie_id');
        $query = Seating::query();
        $query->select('id','s_id','status');
        $query->where('m_id', $movie_data['m_id']);
        $seat_data = $query->get();
        $movie_data['seat_data'] = json_decode($seat_data);
        $movie_data['s_count'] = count($movie_data['seat_data']);
        // echo '<pre>';print_r($movie_data);exit();
        return view('booking',compact('movie_data'));
        
    }

    public function check_seats(Request $request)
    {
        Session::put('movie_id', $request->m_id);
        
        $query = Seating::query();
        $query->select('id');
        $query->where('m_id', $request->m_id);
        $query->where('status', 0);
        $items = $query->get()->count();
        Session::put('seats_count', $items);
        // echo '<pre>';print_r($items);exit();
        return response()->json(['status'=>true,'message' => 'Success message','data'=>$items]);
    }

    public function save_booking(Request $request)
    {
        $m_id = $request->m_id;
        $s_id = $request->s_id;
        $name = $request->name;
        $email = $request->email;

        $count = Booking::where('email',$email)->get()->count();
        // echo '<pre>';print_r($count);exit();
        if($count >= 1)
        {
            return response()->json(['status'=>false,'message' => 'You have already booked with this email id']);
        }else{
            $pos = strpos($email, '@');

            // Extract the domain part after the "@" symbol
            $domain = substr($email, $pos + 1);

            // Check if the domain is "gmail.com"
            if(strcasecmp($domain, 'brand-scapes.com') === 0)
            {
                $book = new Booking();
                $book->m_id = $m_id;
                $book->s_id = $s_id;
                $book->name = $name;
                $book->email = $email;
                $book->save();

                $lastInsertedId = $book->id;
                if($lastInsertedId)
                {
                    Seating::where(['s_id'=> $s_id,'m_id'=>$m_id])->update([
                        'status' => 1
                    ]);

                    $m_data = Movie::where('id',$m_id)->get();
                    $movie_data = json_decode($m_data);
                    // echo '<pre>';print_r($movie_data);exit();
                    $details = [
                        'title' => 'Booked Successfully',
                        'm_name' => $movie_data[0]->m_name,
                        'date' => $movie_data[0]->date,
                        'time' => $movie_data[0]->time,
                        'venue'=> $movie_data[0]->venue,
                        'Seat_Id' => $s_id
                    ];
                   
                    \Mail::to($email)->send(new \App\Mail\BookedMail($details));
                    return response()->json(['status'=>true,'message' => 'Success message']);
                }
            }else{
                return response()->json(['status'=>false,'message' => 'Please check the Email ID']);  
            }

        }
    }
}
