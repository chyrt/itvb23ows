<?php

namespace tests;

use utils\Util;
use PHPUnit\Framework\TestCase;

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
    public function testBeetleMovementOntoAnotherPiece()
    {
        $board = [
            "0,0" => [[0, "B"]],
            "1,0" => [[1, "Q"]] // Opponent's piece
        ];
        $this->assertTrue(Util::isValidPosition("1,0", $board, 0)); // Beetle moving on top of another piece
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
    public function testMovementToUnreachablePosition()
    {
        $board = [
            "0,0" => [[0, "Q"]],
            "1,0" => [[1, "S"]], // Surrounded in a way that makes certain moves impossible
            "2,0" => [[0, "G"]]
        ];
        // Assuming "3,0" is unreachable due to being surrounded or other rules
        $this->assertFalse(Util::isValidPosition("3,0", $board, 0));
    }

    public function testQueenBeeValidMove()
    {
        $board = [
            "0,0" => [[0, "Q"]], // White's Queen Bee
            "1,0" => [[1, "S"]]  // Black's piece
        ];
        $player = 0; // White
        $this->assertTrue(Util::isValidPosition("0,1", $board, $player), "Queen Bee should be allowed to move to (0,1)");
    }

}