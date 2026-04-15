<?php

declare(strict_types=1);

// Load Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables from the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


class NetworkManager
{

    private static $instance = null;
    private $apiKey;
    private $client;
    private $genreList = [];

    private function __construct()
    {
        $this->apiKey = $_ENV['API_KEY'];
        $this->client = new \GuzzleHttp\Client();

        // Fetch genres and populate the genre list
        $this->fetch_genres();

    }

    public static function get_instance(): NetworkManager
    {
        if (self::$instance === null) {
            self::$instance = new NetworkManager();
        }

        return self::$instance;
    }

    // A helper function to map genre IDs to genre names for a list of movies
    private function map_genres_to_movies(array $movies): array
    {
        foreach ($movies as &$movie) {
            if (isset($movie['genre_ids']) && is_array($movie['genre_ids'])) {
                $movie['genres'] = array_map(function ($genreId) {
                    return $this->genreList[$genreId] ?? 'Unknown';
                }, $movie['genre_ids']);
            } else {
                $movie['genres'] = ['Unknown'];
            }
        }

        return $movies;
    }

    // Fetch the movie list of genres and store it in the genreList property
    private function fetch_genres()
    {
        $response = $this->client->request('GET', 'https://api.themoviedb.org/3/genre/movie/list?language=en', [
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

        // Check if the 'genres' key exists in the response data
        if (!isset($data['genres'])) {
            throw new Exception("Invalid response from API");
        }

        foreach ($data['genres'] as $genre) {
            $this->genreList[$genre['id']] = $genre['name'];
        }
    }

    // Get movies by search keyword
    public function search_movies(string $keyword): array
    {
        $movies = [];
        $i = 1;
        while (true) {

            $movie_filter = [];


            $response = $this->client->request('GET', "https://api.themoviedb.org/3/search/multi?query=$keyword&include_adult=false&language=en-US&page=$i", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'accept' => 'application/json',
                ],
            ]);

            // Check if the response status code is 200 (OK)
            if ($response->getStatusCode() !== 200) {
                throw new Exception("Failed to fetch movies: " . $response->getStatusCode());
            }

            // Decode the JSON response into an associative array
            $data = json_decode($response->getBody()->getContents(), true);

            // Check if the 'results' key exists in the response data
            if (!isset($data['results'])) {
                throw new Exception("Invalid response from API");
            }

            // Filter the results to include only movies 
            foreach ($data['results'] as $movie) {
                // Check if the media type is 'movie' and add it to the movie filter array
                if (isset($movie['media_type']) && $movie['media_type'] === 'movie') {
                    $movie_filter[] = $movie;
                }
                // If the media type is 'person', we can also check their known movies and add those to the movie filter array
                elseif (isset($movie['media_type']) && $movie['media_type'] === 'person') {
                    foreach ($movie['known_for'] as $known_movie) {
                        if (isset($known_movie['media_type']) && $known_movie['media_type'] === 'movie') {
                            $movie_filter[] = $known_movie;
                        }
                    }
                }
            }

            // Merge the movies from the current page into the main movies array
            $movies = array_merge($movies, $movie_filter);

            // Check if there are more pages to fetch based on the total_pages value in the response data
            // If there are more pages and we haven't reached the limit of 50 movies, increment the page number and continue fetching
            if ($data['total_pages'] > $i && count($movies) < 50) {
                $i++;
            } else {
                break;
            }
        }

        return $this->map_genres_to_movies($movies);
    }

    // Get the details of a specific movie
    public function get_movie_details(int $movie_id): array
    {
        $response = $this->client->request('GET', "https://api.themoviedb.org/3/movie/$movie_id?language=en-US", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'accept' => 'application/json',
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new Exception("Failed to fetch movie details: " . $response->getStatusCode());
        }

        $data = json_decode($response->getBody()->getContents(), true);

        // Extract genre names directly
        $data['genres'] = array_column($data['genres'], 'name');

        return $data;
    }

    public function get_trending_movies(): array
    {

        $movies = [];

        // Fetch trending movies from the first 5 pages
        for ($i = 1; $i <= 5; $i++) {
            $response = $this->client->request('GET', "https://api.themoviedb.org/3/movie/popular?language=en-US&page=$i", [
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

        return $this->map_genres_to_movies($movies);
    }


    public function get_trending_banners(int $limit = 10): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/trending/movie/week',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'accept' => 'application/json',
                ],
            ]
        );

        if ($response->getStatusCode() !== 200) {
            throw new Exception("Failed to fetch trending movies");
        }

        $data = json_decode($response->getBody()->getContents(), true);

        if (!isset($data['results'])) {
            throw new Exception("Invalid response from API");
        }

        $banners = [];

        foreach ($data['results'] as $movie) {
            if (!empty($movie['backdrop_path'])) {
                $banners[] = [
                    'title' => $movie['title'],
                    'overview' => $movie['overview'],
                    'backdrop' => 'https://image.tmdb.org/t/p/original' . $movie['backdrop_path'],
                    'poster' => 'https://image.tmdb.org/t/p/w500' . ($movie['poster_path'] ?? ''),
                    'id' => $movie['id']
                ];
            }

            if (count($banners) >= $limit) {
                break;
            }
        }

        return $banners;
    }
}

