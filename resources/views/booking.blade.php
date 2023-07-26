@extends('layouts.front_app')

@section('front_content')  

    <!-- Main Page Content -->
    <div class="container mt-0">
        <div class="row justify-content-center">
            <div class="col-8 ">
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

                            <div class="screen"> SCREEN</div>
                            <!-- <div class="loader" style="display: none;">
                                <div class="loader__filmstrip">
                                </div>
                                <p class="loader__text">
                                    loading
                                </p>
                            </div> -->
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
        <div class="loader-wrapper">
          <div class="loader"> 
          <div class="loader__filmstrip">
          </div> 
          <p class="loader__text">
                      loading
          </p>
          </div>
        </div>
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

  @endsection

@section('footer-external-script')
  
    <script type="text/javascript">
      
      $(document).ready(function () {
        $('#bookingModal').on('show.bs.modal', function (event) {
            $(".loader-wrapper").fadeOut("slow");
            var button = $(event.relatedTarget);
            var mid = button.data('mid');
            var sid = button.data('sid');
            $('#m_id').val(mid);
            $('#s_id').val(sid);
        });

        $("#modalSubmitButton").on('click',function(){
            $(".loader-wrapper").fadeOut("slow");
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
              // $(".loader").show();
              $(".loader-wrapper").fadeIn();
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
                        // $(".loader").hide();
                        $(".loader-wrapper").fadeOut("slow");
                        $('#regbooking_modal')[0].reset();
                            // Handle success response
                        swal.fire('Success', "Booked Successfully", 'success');
                        $('#bookingModal').modal('toggle');
                        var seatId = $('#s_id').val();
                        $('#' + seatId).removeClass('occupied');
                        $('#' + seatId).addClass('selected').prop('disabled', true);
                      } else{
                        $(".loader-wrapper").fadeOut("slow");
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
@endsection
