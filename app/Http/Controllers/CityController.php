<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CityController extends Controller
{
    public function get_all_city()
    {
        $city = new City();        
        $details = $city->getDetails();
        return view('city.view', ['details' => $details]);
        // echo '<pre>';print_r($details);exit();
    }

    public function add_city()
    {
        return view('city.create');
    }

    public function save_city(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        try {
            $encryptedString = base64_encode($validatedData['name']);            
            $city = new City();
            $city->name = $validatedData['name'];
            $city->c_id = $encryptedString;
            $city->save();
            return redirect('/city')->with('success', 'City data saved successfully!');
        }catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e.'Failed to save city data. Please try again.']);
        }    
    }
}
