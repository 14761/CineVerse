<?php

$server = "localhost";
$userName = "root";
$password = "";
$db = "MovieReviewDB";

$connection = new mysqli($server, $userName, $password, $db);
if ($connection->connect_error) {
    die("connection has failed". $connection->connect_error);
}

echo("connected...")






?>