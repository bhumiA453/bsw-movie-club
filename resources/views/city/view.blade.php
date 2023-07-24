@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">City</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">City</li>
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
                    <a href="{{ route('create-city') }}" class="btn btn-primary">Add City</a>
                </div>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session('success') }}
                    </div>
                @endif
                <table id="city_data" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>City ID</th>
                  </tr>
                  </thead>
                  <tbody>
                  @if ($details->count() > 0)
                      @foreach($details as $detail)
                          <tr>
                              <td>{{ $detail->id }}</td>
                              <td>{{ $detail->name }}</td>
                              <td>{{ $detail->c_id }}</td>
                              <!-- Add more columns as needed -->
                          </tr>
                      @endforeach
                  @else
                      <tr>
                          <td colspan="3">No data available.</td>
                      </tr>
                  @endif
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>City ID</th>
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
    $("#city_data").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,"paging": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#city_data_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection