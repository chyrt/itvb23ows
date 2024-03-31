<?php

include_once '../../config.php';

$host = getenv("DB_HOST");
$user = getenv("DB_USER");
$pass = getenv("DB_PASS");
$name = getenv("DB_NAME");

function getState() {
    return serialize([$_SESSION['hand'], $_SESSION['board'], $_SESSION['player']]);
}

function setState($state) {
    list($a, $b, $c) = unserialize($state);
    $_SESSION['hand'] = $a;
    $_SESSION['board'] = $b;
    $_SESSION['player'] = $c;
}

$conn = new mysqli($host, $user, $pass, $name);

// Controleer de connectie
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
return $conn;
