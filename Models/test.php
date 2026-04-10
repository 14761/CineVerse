<?php

require_once __DIR__ . '/../Models/DBManager.php';

$db = DBManager::get_instance();

$result = $db->create_user("Test User", "test@email.com", "123456");

if ($result) {
    echo "User inserted!";
} else {
    echo "Insert failed.";
}