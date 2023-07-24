<!DOCTYPE html>
<html>
<head>
    <title>BSW Movie Club</title>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <h4>Hi Admin,</h4>
    <p>PFB user booked details:</p>
    <p>User Name: {{$details['u_name']}}</p>
    <p>User Email: {{$details['email']}}</p>
    <p>Movie Name: {{ $details['m_name'] }}</p>
    <p>Movie Date: {{date('d M Y',strtotime($details['date']))}}</p>
    <p>Movie Time: {{date('h:iA',strtotime($details['time']))}}</p>
    <p>Movie Venue: {{ $details['venue'] }}</p>
    <p>Seat Id:{{$details['Seat_Id']}}</p>
   
    <p>Thank you</p>
</body>
</html>