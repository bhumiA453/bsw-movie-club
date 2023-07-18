<!DOCTYPE html>
<html lang="en">
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

<body>
    <!-- Trailer Video Modal -->
    <div class="modal" id="trailer">
      <div class="modal-dialog">
        <div class="modal-content">
          <a href="#" class="hanging-close" data-dismiss="modal" aria-hidden="true">
            <img src="{{ asset('dist/img/close-icon.png')}}" alt="Close"/>
          </a>
          <div class="scale-media" id="trailer-video-container">
          </div>
        </div>
      </div>
    </div>

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
        <div class="row">
            <div class="col-12">
                <h1 class="display-3 lead">Welcome to BSW Movie Club</h1>
                
            </div>
        </div>
        <div class="row justify-content-md-center">
          @foreach($items as $item)
            <div class="col-md-4 movie-tile text-center">
              <div class="movie-poster">
                    <img src="{{asset('storage/' . $item->m_image)}}" alt="movie poster image">
                    <!-- This is used to overlay the content over the poster images on hover -->
                    <div class="movie-info">
                        <table>
                            <tr>
                                <td class="text-center align-middle">
                                    <p><b>Venue: {{$item->venue}}</b></p>
                                    <p><b>Date-Time:</b> {{date('h:iA',strtotime($item->time))}} | {{date('d M Y',strtotime($item->date))}}</p>
                                    <p><b>Genres: {{$item->genres}}</b></p>
                                    <p><b>Cast: {{$item->cast}}</b></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <h2>{{$item->m_name}}</h2>
                <div>
                  @csrf
                  <input type="hidden" name="m_id" class="m_id" id="m_id" value="{{$item->id}}">
                  <button type="submit" class="button button--moema button--text-thick button--text-upper button--size-s text-center book_now" id="book_now">Book Now</button>
                  <!-- <button class="button button--moema button--text-thick button--text-upper button--size-s text-center" data-toggle="modal" data-id="{{$item->id}}" data-target="#bookingModal">Book Now</button> -->
                </div>
            </div>
            <!-- <div class="col-md-4 movie-tile text-center" data-trailer-youtube-id="MnF4SpS9gUw" data-toggle="modal" data-target="#trailer">
              <div class="movie-poster">
                    <img src="https://upload.wikimedia.org/wikipedia/en/9/9f/Sucker_Punch_film_poster.jpg" alt="movie poster image">
                    
                    <div class="movie-info">
                        <table>
                            <tr>
                                <td class="text-center align-middle">
                                    <p style="color:#fff;">A young girl is institutionalized by her abusive stepfather, retreating to an alternative reality as a coping strategy, envisioning a plan to help her escape.</p>
                                    <p><b>Length: 1h 50min</b></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <h2>Sucker Punch</h2>
            </div> -->
          @endforeach
        </div>

    </div>

    <!-- jQuery -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('dist/js/mainjs.js')}}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function () {
        /*$('#bookingModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            $('#m_id').val(id);
        });*/

        $('.book_now').click(function(event) {
          event.preventDefault(); // Prevent the form from submitting normally

          // Get the form data
          var formData = {
            m_id: $(this).prev('.m_id').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
          };
          // Send the AJAX request
          $.ajax({
            type: 'POST',
            url: '/check-seats',
            data: formData,
            success: function(response) {
              // Handle the response from the server
              // console.log(response);
              // return false;
              if(response.status == true)
              {
                if(response.data > 0)
                {
                  window.location.href = '/booking';
                }else{
                  swal.fire('Error', "Seats not available", 'error');
                }
              }
              // You can perform additional actions here based on the response
            },
            error: function(xhr, status, error) {
              // Handle any errors that occurred during the request
              swal.fire('Error', error.response.data.message, 'error');
              console.log(error);
            }
          });
        });
      });
    </script>
  </body>
</html>
