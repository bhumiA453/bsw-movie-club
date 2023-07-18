<!DOCTYPE html>
<html>
<head>
    <title>BSW Movie Club</title>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <p>Movie Name: {{ $details['m_name'] }}</p>
    <p>Movie Date: {{date('d M Y',strtotime($details['date']))}}</p>
    <p>Movie Time: {{date('h:iA',strtotime($details['time']))}}</p>
    <p>Movie Venue: {{ $details['venue'] }}</p>
    <p>Seat Id:{{$details['Seat_Id']}}</p>
   
    <p>Thank you</p>
</body>
</html>