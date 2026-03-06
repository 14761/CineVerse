# 🎬 Movie Hub - Rafael & Phelippe

This is the backend and core structure for our movie review platform.

## 🚀 Setup Instructions for Phelippe

To get this project running on your local XAMPP/WAMP server, follow these steps:

### 1. Install Dependencies
This project uses **Guzzle HTTP Client** for API requests to TMDb. The `vendor/` folder is git-ignored, so you must install it and other dependencies locally:

```bash
# If you are starting fresh or Guzzle isn't in composer.json yet:
composer require guzzlehttp/guzzle

# If the composer.json is already updated:
composer install

### 2. Database Initialization
Run the following query on phpMyAdmin:

```sql
CREATE DATABASE IF NOT EXISTS MovieReviewDB;
USE MovieReviewDB;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Long enough for BCRYPT hashing
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Movies Table (Caching TMDb data)
CREATE TABLE movies (
    id INT PRIMARY KEY, -- We use the TMDb ID here
    title VARCHAR(255) NOT NULL,
    poster_path VARCHAR(255),
    release_date DATE
);

-- Reviews Table
CREATE TABLE reviews (
    user_id INT NOT NULL,
    movie_id INT NOT NULL,
    rating DECIMAL(2,1) DEFAULT 0.0 CHECK (rating >= 0.0 AND rating <= 5.0),
    comment TEXT,
    PRIMARY KEY (user_id, movie_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);

-- Favorites Table
CREATE TABLE favorites (
    user_id INT NOT NULL,
    movie_id INT NOT NULL,
    PRIMARY KEY (user_id, movie_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);
```

---
