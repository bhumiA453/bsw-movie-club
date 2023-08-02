@extends('layouts.front_app')

@section('front_content')
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

    <div class="loader-wrapper">
      <div class="loader"> 
      <div class="loader__filmstrip">
      </div> 
      <p class="loader__text">
                  loading
      </p>
      </div>
    </div>

    <!-- Main Page Content -->
    <div class="container mt-0">
        <div class="row">
            <div class="col-12">
                <h1 class="display-3 lead">Welcome to BSW Movie Club</h1>
                
            </div>
        </div>
        <div class="row justify-content-md-center">
          @if ($items->count() > 0)
          @foreach($items as $item)
            <div class="col-md-4 movie-tile text-center" >
              <div class="movie-poster" data-trailer-youtube-id="{{$item->trailer_id}}" title="Click for Trailer" data-toggle="modal" data-target="#trailer">
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
          @endforeach
          @else
            <img src="{{ asset('dist/img/coming-soon.png')}}" alt="Coming Soon">
          @endif
        </div>

    </div>

@endsection

@section('footer-external-script')
    
    <script type="text/javascript">
      $(window).on("load", function () {
        $(".loader-wrapper").fadeOut("slow");
      });
      $(document).ready(function () {

        /*$('#bookingModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            $('#m_id').val(id);
        });*/

        $('.book_now').click(function(event) {
          event.preventDefault(); // Prevent the form from submitting normally
          $(".loader-wrapper").fadeIn("slow");
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
              $(".loader-wrapper").fadeOut("slow");
              // Handle the response from the server
              // console.log(response);
              // return false;
              if(response.status == true)
              {
                if(response.data > 0)
                {
                  window.location.href = '/booking';
                }else{
                  swal.fire('Housefull', "Seats not available", 'error');
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
@endsection
