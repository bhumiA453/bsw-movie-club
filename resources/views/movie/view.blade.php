@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
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
              <li class="breadcrumb-item active">Movie</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="mb-3">
                    <a href="{{ route('create') }}" class="btn btn-primary">Add Movie</a>
                </div>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session('success') }}
                    </div>
                @endif
                <table id="movie_data" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>id</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Venue</th>
                    <th>Genres</th>
                    <th>City</th>
                    <th>Active</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @if ($details->count() > 0)
                      @foreach($details as $detail)
                          <tr>
                              <td>{{ $detail->id }}</td>
                              <td>{{ $detail->m_name }}</td>
                              <td>{{ $detail->date }}</td>
                              <td>{{ $detail->time }}</td>
                              <td>{{ $detail->venue }}</td>
                              <td>{{ $detail->genres }}</td>
                              <td>{{ $detail->city }}</td>
                              <td>
                                @if ($detail->is_active == 1)
                                  Active
                                @else
                                    Inactive
                                @endif
                              </td>
                              <td>
                                  <a href="{{ route('edit-movie', $detail->id) }}" class="btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                  <form action="{{ route('delete-movie', $detail->id) }}" method="POST" style="display: inline;">
                                      @csrf
                                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')" title="Delete">
                                          <i class="fas fa-trash"></i>
                                      </button>
                                  </form>
                              </td>
                              <!-- Add more columns as needed -->
                          </tr>
                      @endforeach
                  @else
                      <tr>
                          <td colspan="9">No data available.</td>
                      </tr>
                  @endif
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>id</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Venue</th>
                    <th>Genres</th>
                    <th>City</th>
                    <th>Active</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>

              </div>
            </div>

          </div>
          <!-- /.col-md-6 -->
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @endsection

@section('script')
  <script>
  $(function () {
    $("#movie_data").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,"paging": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#movie_data_wrapper .col-md-6:eq(0)');
    /*$('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });*/
  });
</script>
@endsection