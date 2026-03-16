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



    // Fetch trending movies from the first 5 pages
    public function get_movie_by_id($movieId)
    {
        $data = [];

        $response = $this->client->request('GET', "https://api.themoviedb.org/3/movie/$movieId?language=en-US", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'accept' => 'application/json',
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new Exception("Failed to fetch movie details: " . $response->getStatusCode());
        }

        $data = json_decode($response->getBody()->getContents(), true);

        if (!$data || isset($data['success']) && $data['success'] === false) {
            throw new Exception("Invalid response from API");
        }

        return $data;
    }
}

