<?php

namespace tests;

use utils\Util;
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../utils/util.php';

class UtilTest extends TestCase
{
    public function testIsValidPosition()
    {
        // Assuming '0,1' is a valid position with an empty board and player 0
        $board = []; // Example empty board
        $player = 0; // Example player
        $position = '0,1'; // Position to test

        // Call the method under test
        $result = Util::isValidPosition($position, $board, $player);

        // Assert that the position is valid
        $this->assertTrue($result, "The position $position should be considered valid.");
    }
    public function testCannotPlaceNextToOpponentAfterFirstMove()
    {
        $board = [
            "0,0" => [[0, "Q"]], // Player 0's piece
            "1,0" => [[1, "S"]]  // Player 1's piece
        ];
        $this->assertFalse(Util::isValidPosition("2,0", $board, 0)); // Attempting to place next to opponent's piece
    }
    public function testQueenBeePlayedByFourthTurn()
    {
        $board = [
            "0,0" => [[0, "S"]],
            "1,0" => [[0, "A"]],
            "2,0" => [[0, "G"]]
        ];
        // Assuming a method or logic exists to enforce Queen Bee placement by the fourth turn
        $this->assertTrue(Util::isValidPosition("3,0", $board, 0)); // Should be valid if it's the Queen Bee being placed
    }

    public function testMoveThatWouldSplitHive()
    {
        $board = [
            // Simulating a scenario where moving a piece would split the hive
            "0,0" => [[0, "Q"]],
            "1,0" => [[0, "S"]],
            "2,0" => [[0, "A"]],
            "3,0" => [[0, "B"]]
        ];
        $this->assertFalse(Util::isValidPosition("2,0", $board, 0)); // Moving piece at "2,0" would split the hive
    }

    public function testQueenBeeSlide()
    {
        // Simulate the board state
        $board = [
            "0,0" => [[0, "Q"]], // White Queen Bee at (0, 0)
            "1,0" => [[1, "S"]]  // Black piece at (1, 0)
        ];

        // Attempt to move the White Queen Bee from (0, 0) to (0, 1)
        $from = "0,0";
        $to = "0,1";

        // Assert that the slide is valid
        $this->assertTrue(Util::slide($board, $from, $to), "The Queen Bee should be allowed to slide from (0, 0) to (0, 1).");
    }

    public function testQueenPlayedWithinFirstThreeMoves() {
        $hand = ['Q' => 1, 'A' => 1, 'B' => 1, 'C' => 1];
        $this->assertFalse(Util::validatePlayQueenWithinFourMoves('Q', $hand));
    }

    public function testQueenNotPlayedWithinFirstThreeMoves() {
        $hand = ['Q' => 1, 'A' => 0, 'B' => 0, 'C' => 0];
        $this->assertTrue(Util::validatePlayQueenWithinFourMoves('A', $hand));
    }

    public function testMoreThanThreeMovesWithoutPlayingQueen() {
        $hand = ['Q' => 1, 'A' => 0, 'B' => 0, 'C' => 0, 'D' => 1];
        $this->assertTrue(Util::validatePlayQueenWithinFourMoves('D', $hand));
    }

    public function testFreePositionAfterMove()
    {
        // Scenario setup: een eenvoudig bord met één steen die verplaatst zal worden
        $board = [
            '0,0' => [['W', 'B']], // Aanname: formaat [Player, PieceType]
            '1,1' => [] // Bestemming positie
        ];
        $from = '0,0';
        $to = '1,1';

        // Voer de beweging uit
        $tile = array_pop($board[$from]);
        $board[$to][] = $tile;

        // Roep de methode aan die getest wordt
        Util::freePositionAfterMove($board, $from);

        // Assertions
        $this->assertEmpty($board[$from], "De oorspronkelijke positie moet leeg zijn na het verplaatsen.");
        $this->assertNotEmpty($board[$to], "De bestemmingspositie moet niet leeg zijn na het verplaatsen.");
    }

}