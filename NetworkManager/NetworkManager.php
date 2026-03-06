<?php

declare(strict_types=1);
require_once('vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


class NetworkManager {

    private $apiKey;

    public function __construct()
    {
        // $apiKey = 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI0NTU3NzkxYmZkYTZjMDBjYzdlZDdhYzI3YzAxZDNjMiIsIm5iZiI6MTc3MTk5NjQ3MC40Miwic3ViIjoiNjk5ZTg1MzZhMjk4OTVmYTAzZjIyOWJmIiwic2NvcGVzIjpbImFwaV9yZWFkIl0sInZlcnNpb24iOjF9.J3Ycks23if9YvPPW3U4IMyHbvADdUF1-USvQkESJV1A';
        $apiKey = $_ENV['API_KEY'];
    }
    
    function getTrendingMovies() {
        
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://api.themoviedb.org/3/trending/movie/day?language=en-US', [
        'headers' => [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'accept' => 'application/json',
        ],
        ]);

        echo $response->getBody();
    }
}