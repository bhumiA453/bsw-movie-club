<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>BSW Movie Club</title>

    <!-- Styles -->
    <link href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700;900&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dist/css/main-style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
</head>
<body class="booking_body">
  
    <!--  Header -->
     <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-5 navbar-bg">
      
      <div class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <div class="main-logo">
             <a href="{{route('home')}}" class="align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none"><img src="{{ asset('dist/img/BSW-Movie-Club-Logo.png')}}" alt="BSW Movie Club"></a> 
         </div>
      </div>
      <div class="col-md-3 text-end">
        <!-- <button type="button" class="btn btn-outline-primary me-2">Login</button>
        <button type="button" class="btn btn-primary">Sign-up</button> -->
      </div>
    </header>

    <!-- Main Page Content -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-6">
                 <h1 class="display-3 lead">Choose The Seat Here</h1>
                 <div class="row ">
                    <div class="col-md-12 movie-seating text-center">

                        <ul class="showcase">
                            <li>
                                <div class="seat selected"></div>
                                <small>Occupied</small>
                            </li>
                            <li>
                                <div class="seat occupied"></div>
                                <small>Available</small>
                            </li>
                        </ul>

                        <div class="movcontainer">

                            <div class="screen"></div>
                            <div class="loader" style="display: none;">
                                <div class="loader__filmstrip">
                                </div>
                                <p class="loader__text">
                                    loading
                                </p>
                            </div>
                            <div id="seatingArrangement">    
                                <?php
                                // Calculate the number of rows and columns
                                
                                $columns = 6;
                                $rows = $movie_data['s_count']/$columns;
                                $totalSeats = $rows * $columns;

                                // Generate the seating arrangement HTML dynamically in a 5x6 grid
                                for ($i = 1; $i <= $totalSeats; $i++) {
                                  $mid = $movie_data['m_id'];
                                  foreach($movie_data['seat_data'] as $value)
                                  {
                                    if($i == $value->s_id)
                                    {
                                      if($value->status == 0)
                                      {
                                        echo '<button class="seat occupied " id="'.$i.'" data-toggle="modal" data-sid="'.$i.'" data-mid="'.$mid.'" data-target="#bookingModal" >' . $i . '</button>';
                                      }else{
                                        echo '<button class="seat selected seat-booked" id="'.$i.'" disabled >' . $i . '</button>';
                                      }
                                    }
                                  }
                                  
                                  if ($i % $columns === 0) {
                                    echo '<br>';
                                  }
                                }
                                ?>
                            </div>
                        </div>                         
                    </div>
                </div>
            </div>
        </div>
    </div>

    

  <!-- Modal -->
  <div class="modal" id="bookingModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Register</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="regbooking_modal" class="regbooking_modal">
                  @csrf
            <div class="modal-body">
                
                    <div class="form-group">
                        <label for="input1">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="input2">Email</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <input type="hidden" name="m_id" id="m_id">
                    <input type="hidden" name="s_id" id="s_id">
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="modalSubmitButton">Book Now</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
  </div>
  <!-- jQuery -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js" integrity="sha512-6S5LYNn3ZJCIm0f9L6BCerqFlQ4f5MwNKq+EthDXabtaJvg3TuFLhpno9pcm+5Ynm6jdA9xfpQoMz2fcjVMk9g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('dist/js/mainjs.js')}}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function () {
        $('#bookingModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var mid = button.data('mid');
            var sid = button.data('sid');
            $('#m_id').val(mid);
            $('#s_id').val(sid);
        });

        $("#modalSubmitButton").on('click',function(){
          $('#regbooking_modal').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                    minlength: "Name must be at least 2 characters"
                },
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address"
                }
            },
            submitHandler: function (form) {
              $(".loader").show();
                // Serialize form data
                var formData = $(form).serialize();
                // console.log(formData);return false;
                // AJAX request to save form data
                $.ajax({
                    url: '/save-seat-data',
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        // console.log(response);return false;
                      if(response.status == true)
                      {
                        $(".loader").hide();
                        $('#regbooking_modal')[0].reset();
                            // Handle success response
                        swal.fire('Success', "Booked Successfully", 'success');
                        $('#bookingModal').modal('toggle');
                        var seatId = $('#s_id').val();
                        $('#' + seatId).removeClass('occupied');
                        $('#' + seatId).addClass('selected').prop('disabled', true);
                      } else{
                        $('#regbooking_modal')[0].reset();
                        swal.fire('Error', response.message, 'error');
                        $('#bookingModal').modal('toggle');
                      } 
                    },
                    error: function () {
                        // Handle error
                      swal.fire('Error', error.response.data.message, 'error');
                    }
                });
            }
        });
        });
        
      });
    </script>
</body>
</html>
