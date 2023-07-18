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
              <li class="breadcrumb-item active">Create Movie</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="container">
        <h2>Add New Movie</h2>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('save-seat-data') }}">
            @csrf
            <div class="form-group">
                <label for="status">Select Movie:</label>
                <select class="form-control" id="m_id" name="m_id" required>
                    <option value="">Select Movie</option>
                    @foreach($items as $item)
                    <option value="{{$item->id}}">{{$item->m_name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="name">No. Of Seats:</label>
                <input type="number" class="form-control" id="seats" name="seats" required>
            </div>
                        
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
