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

    // Additional tests for other scenarios (occupied positions, invalid adjacency, etc.)
}