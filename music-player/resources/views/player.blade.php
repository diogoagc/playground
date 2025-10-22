<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Music Player</title>
</head>
<body>
    <h1>Simple Player</h1>
    <audio controls>
        <source src="{{ asset('audio/music-example.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
</body>
</html>
