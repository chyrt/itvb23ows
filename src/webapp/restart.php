<?php

session_start();

$_SESSION['board'] = [];
$_SESSION['hand'] = [0 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3], 1 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3]];
$_SESSION['player'] = 0;

require_once 'database.php';

$dbSingleton = DatabaseSingleton::getInstance();
$stmt = $dbSingleton->prepare('INSERT INTO games VALUES ()');
$stmt->execute();

$_SESSION['game_id'] = $dbSingleton->getInsertId();

header('Location: index.php');
