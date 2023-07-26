@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Seating</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Seating</li>
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
                    <a href="{{ route('create-seats') }}" class="btn btn-primary">Add Seats</a>
                </div>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session('success') }}
                    </div>
                @endif
                <table id="seating_data" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Movie Name</th>
                    <th>City</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
                  @if ($details->count() > 0)
                      @foreach($details as $detail)
                          <tr>
                              <td>{{ $detail->id }}</td>
                              <td>{{ $detail->m_name }}</td>
                              <td>{{ $detail->city }}</td>
                              <td>
                                @if ($detail->status == 1)
                                  Booked
                                @else
                                    Available
                                @endif
                              </td>
                              <!-- Add more columns as needed -->
                          </tr>
                      @endforeach
                  @else
                      <tr>
                          <td colspan="4">No data available.</td>
                      </tr>
                  @endif
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Movie Name</th>
                    <th>City</th>
                    <th>Status</th>
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
    $("#seating_data").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,"paging": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#seating_data_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection