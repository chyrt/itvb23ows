<?php

session_start();

require_once 'database.php'; // Ensure this points to your Singleton class file

if (!isset($_SESSION['last_move'])) {
    header('Location: error.php');
    exit;
}

// Use the Singleton instance for the database connection
$dbSingleton = DatabaseSingleton::getInstance();

// Prepare and execute the query safely to avoid SQL injection
// Assuming $dbSingleton->prepare() correctly initializes a prepared statement
$stmt = $dbSingleton->prepare('SELECT * FROM moves WHERE id = ?');
$stmt->bind_param('i', $_SESSION['last_move']);
$stmt->execute();

$result = $stmt->get_result()->fetch_array();

// Update the session's last move to the previous one
$_SESSION['last_move'] = $result['previous_id'];

// Use the setState method from the DatabaseSingleton instance
// Assuming setState has been correctly implemented within your DatabaseSingleton
$dbSingleton->setState($result['state']);

header('Location: index.php');