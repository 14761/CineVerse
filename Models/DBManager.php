<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';


// Load environment variables from the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class DBManager
{
    // private static $instance = null;
    // private $server;
    // private $userName;
    // private $password;
    // private $db;
    // private $port;
    // private $connection;
    private static $instance = null;
    private $server = "localhost";
    private $userName = "root";
    private $password = "root";
    private $db = "MovieReviewDB";
    private $port = 8889;
    private $connection;

    private function __construct()
    {
        // $this->server = $_ENV['DB_HOST'];
        // $this->userName = $_ENV['DB_USER'];
        // $this->password = $_ENV['DB_PASS'];
        // $this->db = $_ENV['DB_NAME'];
        // $this->port = $_ENV['DB_PORT'];
        $this->connection = new mysqli($this->server, $this->userName, $this->password, $this->db, $this->port);

        if ($this->connection->connect_error) {
            die("connection has failed" . $this->connection->connect_error);
            throw new Exception("Connection failed: " . $this->connection->connect_error);
        }
    }

    // Prevent cloning of the singleton instance
    public function __clone()
    {
    }

    // Prevent unserialization of the singleton instance
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton.");
    }

    // Method to get the singleton instance of DBManager
    public static function get_instance(): DBManager
    {
        if (self::$instance === null) {
            self::$instance = new DBManager();
        }

        return self::$instance;
    }

    //////////////////////////////////////////////////////////////////////
    // ------------------Database interaction methods------------------
    //////////////////////////////////////////////////////////////////////


    ///////////////////////////////////////////////////////////////////////
    // ------------------Database reviews table methods------------------
    //////////////////////////////////////////////////////////////////////

    public function rate_movie(int $userId, int $movieId, float $rating, string $comment): bool
    {
        // Check if the user has already rated the movie
        $checkQuery = $this->connection->prepare("SELECT * FROM reviews WHERE user_id = ? AND movie_id = ? AND rating IS NOT NULL");
        $checkQuery->bind_param("ii", $userId, $movieId);
        $checkQuery->execute();
        $checkResult = $checkQuery->get_result();

        if ($checkResult->num_rows > 0) {
            // If the user has already rated the movie, update the existing rating
            $updateQuery = $this->connection->prepare("UPDATE reviews SET rating = ?, comment = ? WHERE user_id = ? AND movie_id = ?");
            $updateQuery->bind_param("dsii", $rating, $comment, $userId, $movieId);
            $updateQuery->execute();
            $result = $updateQuery->affected_rows > 0;
            $updateQuery->close();
            return $result;
        } else {
            // If the user has not rated the movie, insert a new rating
            $insertQuery = $this->connection->prepare("INSERT INTO reviews (user_id, movie_id, rating, comment) VALUES (?, ?, ?, ?)");
            $insertQuery->bind_param("iids", $userId, $movieId, $rating, $comment);
            $insertQuery->execute();
            $result = $insertQuery->affected_rows > 0;
            $insertQuery->close();
            return $result;
        }
    }

    // Method to get the average rating for a specific movie
    public function get_rating_average(int $movieId): float
    {
        // Prepare and execute the query to get the average rating for the specified movie
        $query = $this->connection->prepare("SELECT AVG(rating) as average FROM reviews WHERE movie_id = ?");
        $query->bind_param("i", $movieId);
        $query->execute();
        $result = $query->get_result();

        // Fetch the average rating from the result
        $row = $result->fetch_assoc();

        // Return the average rating. If there are no ratings, return 0.0
        $average = (float) $row['average'] ?? 0.0;

        $query->close();
        return round($average, 1);
    }

    // Method to get the total number of reviews for a specific movie
    public function get_reviews_count(int $movieId): int
    {
        $query = $this->connection->prepare("SELECT COUNT(*) as total FROM reviews WHERE movie_id = ?");
        $query->bind_param("i", $movieId);
        $query->execute();
        $result = $query->get_result();

        $row = $result->fetch_assoc();
        $count = (int) $row['total'];

        $query->close();
        return $count;
    }

    // Method to get reviews, usernames and comments for a specific movie
    public function get_reviews_by_movie(int $movieId): array
    {
        $query = $this->connection->prepare(
            "SELECT r.rating, r.comment, u.username
         FROM reviews r
         JOIN users u ON r.user_id = u.id
         WHERE r.movie_id = ?
         ORDER BY r.rating DESC"
        );

        $query->bind_param("i", $movieId);
        $query->execute();
        $result = $query->get_result();

        $reviews = [];

        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }

        $query->close();
        return $reviews;
    }

    ///////////////////////////////////////////////////////////////////////
    // ------------------Database favourites table methods------------------
    //////////////////////////////////////////////////////////////////////

    // Checks if a movie is already favourited 
    public function is_favourite(int $userId, int $movieId): bool
    {
        $query = $this->connection->prepare("SELECT 1 FROM favourites WHERE user_id = ? AND movie_id = ? LIMIT 1");
        $query->bind_param("ii", $userId, $movieId);
        $query->execute();
        $result = $query->get_result();

        $isFavourite = $result->num_rows > 0;

        $query->close();
        return $isFavourite;
    }

    // Method to add a movie to a user's favourites
    public function add_to_favourites(int $userId, int $movieId): bool
    {
        $query = $this->connection->prepare("INSERT INTO favourites (user_id, movie_id) VALUES (?, ?)");

        if (!$query) {
            throw new Exception("Failed to prepare add_to_favourites query.");
        }

        $query->bind_param("ii", $userId, $movieId);

        if (!$query->execute()) {
            throw new Exception("Failed to execute add_to_favourites query: " . $query->error);
        }

        $result = $query->affected_rows > 0;
        $query->close();
        return $result;
    }

    // Method to remove a movie from a user's favourites
    public function remove_from_favourites(int $userId, int $movieId): bool
    {
        $query = $this->connection->prepare("DELETE FROM favourites WHERE user_id = ? AND movie_id = ?");

        if (!$query) {
            throw new Exception("Failed to prepare remove_from_favourites query.");
        }

        $query->bind_param("ii", $userId, $movieId);

        if (!$query->execute()) {
            throw new Exception("Failed to execute remove_from_favourites query: " . $query->error);
        }

        $result = $query->affected_rows > 0;
        $query->close();
        return $result;
    }

    // Method to get a list of a user's favourite movies
    public function get_favourite_movies(int $userId): array
    {
        $query = $this->connection->prepare("SELECT m.* FROM movies m JOIN favourites f ON m.id = f.movie_id WHERE f.user_id = ?");
        $query->bind_param("i", $userId);
        $query->execute();
        $result = $query->get_result();

        $favouriteMovies = [];

        // Fetch all favourite movies as an associative array
        $favouriteMovies = $result->fetch_all(MYSQLI_ASSOC);

        $query->close();
        return $favouriteMovies;
    }

    ///////////////////////////////////////////////////////////////////////
    // ------------------Database movies table methods------------------
    //////////////////////////////////////////////////////////////////////

    // Method to add a movie to the database
    public function add_movie_to_DB($movie): bool
    {
        $query = $this->connection->prepare("INSERT IGNORE INTO movies (id, title, overview, poster_path, release_date) VALUES (?, ?, ?, ?, ?)");
        $query->bind_param("issss", $movie['id'], $movie['title'], $movie['overview'], $movie['poster_path'], $movie['release_date']);
        $query->execute();
        $result = $query->affected_rows > 0;
        $query->close();
        return $result;
    }

    // Method to add multiple movies to the database
    public function add_movies_to_DB($movies): void
    {
        foreach ($movies as $movie) {
            $this->add_movie_to_DB($movie);
        }
    }

    // Method to get a movie by its ID
    public function get_movie_by_id(int $movieId): ?array
    {
        $query = $this->connection->prepare("SELECT * FROM movies WHERE id = ?");
        $query->bind_param("i", $movieId);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $movie = $result->fetch_assoc();
            $query->close();
            return $movie;
        } else {
            $query->close();
            return null; // Movie not found
        }
    }

    ///////////////////////////////////////////////////////////////////////
    // ------------------Database users table methods------------------
    //////////////////////////////////////////////////////////////////////

    // Method to create a new user in the database
    public function create_user(string $name, string $email, string $password): bool
    {
        // Hash the password before storing it in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = $this->connection->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $query->bind_param("sss", $name, $email, $hashedPassword);
        $query->execute();
        $result = $query->affected_rows > 0;
        $query->close();
        return $result;
    }

    // Method to sign in a user by verifying their email and password
    public function user_sign_in(string $email, string $password): ?array
    {
        $query = $this->connection->prepare("SELECT * FROM users WHERE email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify the password using password_verify
            if (password_verify($password, $user['password'])) {
                $query->close();
                return $user; // Return user data on successful sign-in
            } else {
                $query->close();
                return null; // Incorrect password
            }
        } else {
            $query->close();
            return null; // User not found
        }
    }

    // Method to get a user by their ID
    public function get_user_by_id(int $userId): ?array
    {
        $query = $this->connection->prepare("SELECT * FROM users WHERE id = ?");
        $query->bind_param("i", $userId);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $query->close();
            return $user;
        }

        $query->close();
        return null;
    }

    // Method to update a user's profile information and optionally change the password or profile picture
    public function user_update_account(int $userId, string $name, string $email, ?string $newPassword = null, ?string $profilePicturePath = null): bool
    {
        if ($newPassword !== null && $newPassword !== '') {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            if ($profilePicturePath !== null && $profilePicturePath !== '') {
                $query = $this->connection->prepare("UPDATE users SET username = ?, email = ?, password = ?, profile_picture = ? WHERE id = ?");
                if (!$query) {
                    throw new Exception("Failed to prepare user update query: " . $this->connection->error);
                }
                $query->bind_param("ssssi", $name, $email, $hashedPassword, $profilePicturePath, $userId);
            } else {
                $query = $this->connection->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
                if (!$query) {
                    throw new Exception("Failed to prepare user update query: " . $this->connection->error);
                }
                $query->bind_param("sssi", $name, $email, $hashedPassword, $userId);
            }
        } elseif ($profilePicturePath !== null && $profilePicturePath !== '') {
            $query = $this->connection->prepare("UPDATE users SET username = ?, email = ?, profile_picture = ? WHERE id = ?");
            if (!$query) {
                throw new Exception("Failed to prepare user update query: " . $this->connection->error);
            }
            $query->bind_param("sssi", $name, $email, $profilePicturePath, $userId);
        } else {
            $query = $this->connection->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
            if (!$query) {
                throw new Exception("Failed to prepare user update query: " . $this->connection->error);
            }
            $query->bind_param("ssi", $name, $email, $userId);
        }

        if (!$query->execute()) {
            throw new Exception("Failed to execute user update query: " . $query->error);
        }

        $result = $query->affected_rows > 0;
        $query->close();
        return $result;
    }

    // Method to delete a user's account from the database
    // I'm not sure if this should also delete the user's reviews and favourites, or if we should keep them for historical purposes. For now, it deletes all the information related to the user account.
    public function user_delete_account(int $userId): bool
    {
        $query = $this->connection->prepare("DELETE FROM users WHERE id = ?");
        $query->bind_param("i", $userId);
        $query->execute();
        $result = $query->affected_rows > 0;
        $query->close();
        return $result;
    }


}