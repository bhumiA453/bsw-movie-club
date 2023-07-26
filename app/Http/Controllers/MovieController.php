<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\City;
use App\Models\Seating;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class MovieController extends Controller
{
    public function get_all_movie()
    {
        $today = Carbon::today();
        $movie = new Movie();
        $m_ids = $movie->select('id')->whereDate('date', '<=', $today->toDateString())->get();
        $m_ids = $m_ids->toArray();
        
        if(isset($m_ids) || count($m_ids) > 0)
        {
            Movie::whereIn('id',$m_ids)->update(['is_active' => 0]);
            Seating::whereIn('m_id',$m_ids)->delete();
        }
        
        $details = $movie->getDetails();
        
        return view('movie.view', ['details' => $details]);
        // echo '<pre>';print_r($details);exit();
    }

    public function add_movie()
    {
        return view('movie.create');
    }

    public function save_movie(Request $request)
    {
        // echo '<pre>';print_r($_POST);exit();
        $validatedData = $request->validate([
            'name' => 'required',
            'image' => 'required|image',
            'date' => 'required|date',
            'time' => 'required',
            'description' => 'required',
            'url' => 'required',
            'genres' => 'required',
            'cast' => 'required',
            'city' => 'required',
            'status' => 'required|in:0,1',
        ]);
        try {
            $imagePath = $request->file('image')->store('images', 'public');
            
            foreach($validatedData['city'] as $city)
            {
                $encrypt_city = City::getEncodeID($city);
                $preview_url[] = url('/').'?id='.$encrypt_city; 
            }

            $pattern = '/^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?.*v=|embed\/|v\/)|youtu\.be\/)([^&?\/ ]{11})/';
            preg_match($pattern, $validatedData['url'], $matches);

            if (isset($matches[1])) {
                $video_id = $matches[1];
                // echo '<pre>';print_r($matches[1]);exit();
            } else {
                return redirect()->back()->withInput()->withErrors(['error' => "URL format doesn't match a YouTube video."]); 
            }

            // exit($preview_url);
            $movie = new Movie();
            $movie->m_name = $validatedData['name'];
            $movie->m_image = $imagePath;
            $movie->date = $validatedData['date'];
            $movie->time = $validatedData['time'];
            $movie->venue = $validatedData['description'];
            $movie->trailer_url = $validatedData['url'];
            $movie->trailer_id = $video_id;
            $movie->genres = $validatedData['genres'];
            $movie->cast = $validatedData['cast'];
            $movie->city = implode(",", $validatedData['city']);
            $movie->preview_url = implode(",", $preview_url);
            $movie->is_active = $validatedData['status'];
            $movie->save();

            return redirect('/get_movie')->with('success', 'Movie data saved successfully!');
        }catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to save movie data. Please try again.']);
        }    
    }

    public function edit_movie($id)
    {
        $movie_data = Movie::findOrFail($id);
        return view('movie.update',['item' => $movie_data]);
        // You can pass the $formItem object to the view and display the edit form
    }

    public function update_movie(Request $request, $id)
    {
        
        $validatedData = $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'description' => 'required',
            'url' => 'required',
            'genres' => 'required',
            'cast' => 'required',
            'city' => 'required',
            'status' => 'required|in:0,1',
        ]);
       
        try {
            $movie = Movie::findOrFail($id);

            $movie->m_name = $validatedData['name'];
            // Update other fields as needed

            // Handle image update if necessary
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $movie->m_image = $imagePath;
            }

            $pattern = '/^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?.*v=|embed\/|v\/)|youtu\.be\/)([^&?\/ ]{11})/';
            preg_match($pattern, $validatedData['url'], $matches);

            if (isset($matches[1])) {
                $video_id = $matches[1];
                // echo '<pre>';print_r($matches[1]);exit();
            } else {
                return redirect()->back()->withInput()->withErrors(['error' => "URL format doesn't match a YouTube video."]); 
            }

            foreach($validatedData['city'] as $city)
            {
                $encrypt_city = City::getEncodeID($city);
                $preview_url[] = url('/').'?id='.$encrypt_city;  
            }
            $movie->date = $validatedData['date'];
            $movie->time = $validatedData['time'];
            $movie->venue = $validatedData['description'];
            $movie->trailer_url = $validatedData['url'];
            $movie->trailer_id = $video_id;
            $movie->genres = $validatedData['genres'];
            $movie->cast = $validatedData['cast'];
            $movie->city = implode(",", $validatedData['city']);
            $movie->preview_url = implode(",", $preview_url);
            $movie->is_active = $validatedData['status'];
            $movie->save();

            return redirect('/get_movie')->with('success', 'Movie data updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update movie data. Please try again.']);
        }
    }

    public function delete_movie($id)
    {
        try {
            $movie = Movie::findOrFail($id);
            $movie->delete();

            return redirect('/movie')->with('success', 'Movie data deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete movie data. Please try again.']);
        }
    }
}
