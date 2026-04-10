# CineVerse – Movie Review Web Application

## Overview

CineVerse is a PHP-based web application that allows users to search for movies, view details, and leave ratings and comments. The application integrates with the TMDb (The Movie Database) API to fetch movie data.

This project follows an MVC-like structure and demonstrates backend development using PHP, MySQL, and external API integration.

---

## Features

* User registration and login
* Movie search using TMDb API
* View movie details
* Add ratings and comments
* View average ratings
* Responsive interface

---

## Technologies Used

* PHP
* MySQL
* HTML / CSS
* JavaScript
* TMDb API
* Composer (for dependency management)

---

## Project Structure

```
demo/
│── Controllers/     # Handles application logic
│── Models/          # Database interaction
│── Views/           # UI templates
│── helpers/         # External integrations (API, Firebase, etc.)
│── style.css
│── composer.json
│── CineVerseDB.sql  # Database schema
```

---

## Requirements

* PHP 8+
* MySQL / MariaDB
* Composer
* Web server (XAMPP, MAMP, or Apache)

---

## Setup Instructions

### 1. Clone the Repository

```
git clone <your-repository-url>
cd demo
```

---

### 2. Install Dependencies

```
composer install
```

---

### 3. Environment Configuration

Create a `.env` file in the root directory:

```
TMDB_API_KEY=your_tmdb_api_key_here
DB_HOST=localhost
DB_NAME=MovieReviewDB
DB_USER=root
DB_PASS=root
DB_PORT=3306
```

> Note: Update database credentials depending on your local setup.

---

### 4. Database Setup

1. Create a new database:

```
MovieReviewDB
```

2. Import the SQL file:

```
CineVerseDB.sql
```

---

### 5. Database Schema (Important)

Ensure your `users` table uses:

```
username VARCHAR(100) NOT NULL
```

Example:

```
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);
```

---

### 6. Ratings Configuration (Important)

The application expects ratings from **1 to 10**.

Ensure your database allows this:

```
rating DECIMAL(3,1) CHECK (rating >= 1 AND rating <= 10)
```

---

### 7. Run the Application

Option 1 (XAMPP / MAMP):

* Place project inside `htdocs` or `www`
* Open:

```
http://localhost/demo
```

Option 2 (PHP built-in server):

```
php -S localhost:8000
```

Then open:

```
http://localhost:8000
```

---

## Notes & Known Issues

* Do NOT include the following folders when submitting or cloning:

  * `node_modules/`
  * `vendor/`
  * `.git/`
  * `__MACOSX/`
  * `.DS_Store`

* If you encounter database errors:

  * Check column names (`username` vs `name`)
  * Ensure rating range matches the application (1–10)

* Firebase is included but may require additional configuration if used.

---

## Future Improvements

* Improve error handling and validation
* Move configuration fully into `.env`
* Add user profile management
* Improve UI/UX design

---

## Author

Phelippe Duarte Rafael Cadena

---

## License

This project is for educational purposes only.
