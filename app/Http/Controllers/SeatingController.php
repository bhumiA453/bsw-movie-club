<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seating;
use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class SeatingController extends Controller
{
    public function get_all_seating()
    {
        $seating = new Seating();
        $details = $seating->getDetails();
        return view('seating.view', ['details' => $details]);
        // echo '<pre>';print_r($details);exit();
    }

    public function add_seats()
    {
        $today = Carbon::today();
        $toDate = $today->copy()->addWeek();
        $query = Movie::query();
        $query->select('id','m_name');
        $query->whereDate('date', '>=', $today->toDateString())
            ->whereDate('date', '<=', $toDate->toDateString());
        $query->where('is_active', 1);
        $items = $query->get();
        $items = json_decode($items);
        return view('seating.create',['items' => $items]);
    }

    public function save_seats(Request $request)
    {
        $validatedData = $request->validate([
            'm_id' => 'required',
            'seats' => 'required',
        ]);
        try {
            $no_seats = $request->seats;
            
            for($i = 1;$i<=$no_seats;$i++)
            {
                $seating = new Seating();
                $seating->s_id = $i;
                $seating->m_id = $request->m_id;
                $seating->status = 0;
                $seating->save();
            }
            

            return redirect('/seating')->with('success', 'Seats data saved successfully!');
        }catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to save seats data. Please try again.']);
        } 
    }

}
