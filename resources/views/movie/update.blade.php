@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Movie</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('movie')}}">Movie</a></li>
              <li class="breadcrumb-item active">Update Movie</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="container">
        <h2>Update Movie</h2>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('update', $item->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $item->m_name }}" required>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                @if ($item->m_image)
                    <img src="{{asset('storage/' . $item->m_image)}}" alt="Movie Image" class="mt-2" style="max-width: 200px;">
                @endif
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ $item->date }}" required>
            </div>
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" class="form-control" id="time" name="time" value="{{ $item->time }}" required>
            </div>
            <div class="form-group">
                <label for="description">Venue:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $item->venue }}</textarea>
            </div>
            <div class="form-group">
                <label for="genres">Genres:</label>
                <input type="text" class="form-control" id="genres" name="genres" value="{{ $item->genres }}" required>
            </div>
            <div class="form-group">
                <label for="cast">Cast:</label>
                <input type="text" class="form-control" id="cast" name="cast" value="{{ $item->cast }}" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="1" {{ $item->is_active == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $item->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
