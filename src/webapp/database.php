<?php

require_once __DIR__ . '/vendor/autoload.php';

echo "Het pad naar het .env bestand is: " . __DIR__;
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];
$database = $_ENV['DB_NAME'];

// Maak hier je databaseverbinding met de bovenstaande variabelen
$db = new mysqli($host, $user, $password, $database);


function getState() {
    return serialize([$_SESSION['hand'], $_SESSION['board'], $_SESSION['player']]);
}

function setState($state) {
    list($a, $b, $c) = unserialize($state);
    $_SESSION['hand'] = $a;
    $_SESSION['board'] = $b;
    $_SESSION['player'] = $c;
}

return $db;
