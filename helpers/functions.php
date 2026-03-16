<?php
//////////////////////////////////////////////////////////////////////
// ------------------Helper functions for the app------------------
// This file contains helper functions that can be used across the application
//////////////////////////////////////////////////////////////////////



// A helper function to escape output for safe display in HTML
// This function takes a string value and returns it with special characters converted to HTML entities
// This is important to prevent Cross-Site Scripting (XSS) attacks when displaying user-generated content
// Usage example: echo e($movie['title']);
function e($value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// A helper function to generate the full URL for a movie poster image
// This function takes the image path and an optional size parameter (default is 'w342')
function get_image_url($path, $size = 'w342'): string {
    return "https://image.tmdb.org/t/p/$size" . e($path);
}

