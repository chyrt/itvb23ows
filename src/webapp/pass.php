<?php

session_start();

require_once 'database.php';
$dbSingleton = DatabaseSingleton::getInstance();

$state = $dbSingleton->getState();

$stmt = $dbSingleton->prepare('INSERT INTO moves (game_id, type, move_from, move_to, previous_id, state) VALUES (?, "pass", NULL, NULL, ?, ?)');
$stmt->bind_param('iis', $_SESSION['game_id'], $_SESSION['last_move'], $state);
$stmt->execute();

// Update the last_move with the insert_id directly from the database connection
// Note: Ensure that your DatabaseSingleton class provides a way to access the insert_id
$_SESSION['last_move'] = $dbSingleton->getInsertId();

$_SESSION['player'] = 1 - $_SESSION['player'];

header('Location: index.php');
