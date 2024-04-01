<?php

session_start();

require_once 'database.php'; // Make sure this points to the file where your Singleton is defined
require_once 'utils/util.php';
use utils\Util;

$piece = $_POST['piece'];
$to = $_POST['to'];
if (!isset($_SESSION['player'], $_SESSION['board'])) {
    header('Location: error.php');
    exit;
}
$player = $_SESSION['player'];
$board = $_SESSION['board'];

$hand = $_SESSION['hand'][$player];

if (!$hand[$piece])
    $_SESSION['error'] = "Player does not have tile";
elseif (isset($board[$to]))
    $_SESSION['error'] = 'Board position is not empty';
elseif (count($board) > 0 && !Util::hasNeighBour($to, $board))
    $_SESSION['error'] = "Board position has no neighbour";
elseif (array_sum($hand) < 11 && !Util::neighboursAreSameColor($player, $to, $board))
    $_SESSION['error'] = "Board position has opposing neighbour";
elseif (array_sum($hand) <= 8 && $hand['Q']) {
    $_SESSION['error'] = 'Must play queen bee';
} else {
    $_SESSION['board'][$to] = [[$_SESSION['player'], $piece]];
    $_SESSION['hand'][$player][$piece]--;
    $_SESSION['player'] = 1 - $_SESSION['player'];

    // Use the Singleton instance for the database connection
    $dbSingleton = DatabaseSingleton::getInstance();

    // Adjusted to use the getState method from the singleton instance
    $state = $dbSingleton->getState();

    // Prepare the statement using the database connection from the Singleton
    $stmt = $dbSingleton->prepare('INSERT INTO moves (game_id, type, move_from, move_to, previous_id, state) VALUES (?, "play", ?, ?, ?, ?)');
    $stmt->bind_param('issis', $_SESSION['game_id'], $piece, $to, $_SESSION['last_move'], $state);
    $stmt->execute();

    // Update the last_move with the insert_id directly from the database connection
    // Note: Ensure that your DatabaseSingleton class provides a way to access the insert_id
    $_SESSION['last_move'] = $dbSingleton->getInsertId();
}

header('Location: index.php');