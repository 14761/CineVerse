# 🎬 Movie Hub - Rafael & Phelippe

This is the backend and core structure for our movie review platform.

---

## 🛠 Tech Stack
* **Language:** PHP 8.x
* **HTTP Client:** Guzzle (for TMDb API integration)
* **Database:** MySQL / MariaDB (XAMPP/WAMP)
* **Dependency Manager:** Composer

---

## 🚀 Setup Instructions for Phelippe

Follow these steps to get the project running on your local server:

### 1. Install Dependencies
This project uses **Guzzle HTTP Client** to fetch data from the TMDb API. Since the `vendor/` folder is git-ignored, you must initialize the dependencies:

```bash
# To install all dependencies from the composer.json file:
composer install

# Note: If Guzzle is not yet in the project, run:
# composer require guzzlehttp/guzzle
```

### 2. Database Initialization
Open **phpMyAdmin**, create a database named `MovieReviewDB`, and run the following script in the SQL tab:



```sql
CREATE DATABASE IF NOT EXISTS MovieReviewDB;
USE MovieReviewDB;

-- 1. Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Long enough for BCRYPT hashing
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Movies Table (Caching TMDb data)
CREATE TABLE movies (
    id INT PRIMARY KEY,
    title VARCHAR(255),           
    overview TEXT, 
    poster_path VARCHAR(255),
    release_date DATE
);

-- 3. Reviews Table
CREATE TABLE reviews (
    user_id INT NOT NULL,
    movie_id INT NOT NULL,
    rating DECIMAL(2,1) DEFAULT NULL CHECK (rating >= 0.0 AND rating <= 5.0),
    comment TEXT,
    PRIMARY KEY (user_id, movie_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);

-- 4. Favourites Table
CREATE TABLE favourites (
    user_id INT NOT NULL,
    movie_id INT NOT NULL,
    PRIMARY KEY (user_id, movie_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);
```

### 3. API Configuration
You will need a TMDb API key to fetch movie details.
1. Sign up/Login at [The Movie Database](https://www.themoviedb.org/).
2. Create an API Key in your account settings.
3. Add the key to your `.env` file (do not commit this file to GitHub).

---

## 📌 Project Notes
* **Caching:** We store movie details in the local `movies` table to minimize API calls.
* **Security:** Always use `password_hash()` and `password_verify()` for user authentication.

## 👥 Contributors
* **Rafael Cadena**
* **Phelippe**
