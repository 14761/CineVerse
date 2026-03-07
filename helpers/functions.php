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