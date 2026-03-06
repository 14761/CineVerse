<?php
require_once('vendor/autoload.php');
// $apiKey = $_ENV["API_KEY"];

$client = new \GuzzleHttp\Client();

$response = $client->request('GET', 'https://api.themoviedb.org/3/trending/movie/day?language=en-US', [
  'headers' => [
    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI0NTU3NzkxYmZkYTZjMDBjYzdlZDdhYzI3YzAxZDNjMiIsIm5iZiI6MTc3MTk5NjQ3MC40Miwic3ViIjoiNjk5ZTg1MzZhMjk4OTVmYTAzZjIyOWJmIiwic2NvcGVzIjpbImFwaV9yZWFkIl0sInZlcnNpb24iOjF9.J3Ycks23if9YvPPW3U4IMyHbvADdUF1-USvQkESJV1A' ,
    'accept' => 'application/json',
  ],
]);

echo $response->getBody();