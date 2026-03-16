<?php

declare(strict_types=1);

// Load Composer's autoloader
require_once(__DIR__ . '/../vendor/autoload.php');

// Load environment variables from the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


class NetworkManager
{

    private static $instance = null;
    private $apiKey;
    private $client;

    private function __construct()
    {
        $this->apiKey = $_ENV['API_KEY'];
        $this->client = new \GuzzleHttp\Client();
    }

    public static function get_instance(): NetworkManager
    {
        if (self::$instance === null) {
            self::$instance = new NetworkManager();
        }

        return self::$instance;
    }

    public function get_trending_movies()
    {

        $movies = [];

        // Fetch trending movies from the first 5 pages
        for ($i = 1; $i <= 5; $i++) {
            $response = $this->client->request('GET', "https://api.themoviedb.org/3/trending/movie/day?language=en-US&page=$i", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'accept' => 'application/json',
                ],
            ]);

            // Check if the response status code is 200 (OK)
            if ($response->getStatusCode() !== 200) {
                throw new Exception("Failed to fetch trending movies: " . $response->getStatusCode());
            }

            // Decode the JSON response into an associative array
            $data = json_decode($response->getBody()->getContents(), true);

            // Check if the 'results' key exists in the response data
            if (!isset($data['results'])) {
                throw new Exception("Invalid response from API");
            }

            // Merge the movies from the current page into the main movies array
            $movies = array_merge($movies, $data['results']);
        }

        return $movies;
    }

    
}

