<?php

namespace utils;

class Util
{
    public static $OFFSETS = [[0, 1], [0, -1], [1, 0], [-1, 0], [-1, 1], [1, -1]];

    public static function isNeighbour($a, $b)
    {
        $a = explode(',', $a);
        $b = explode(',', $b);
        if ($a[0] == $b[0] && abs($a[1] - $b[1]) == 1) return true;
        if ($a[1] == $b[1] && abs($a[0] - $b[0]) == 1) return true;
        if ($a[0] + $a[1] == $b[0] + $b[1]) return true;
        return false;
    }

    public static function hasNeighBour($a, $board)
    {
        foreach (array_keys($board) as $b) {
            if (self::isNeighbour($a, $b)) return true;
        }
        return false;
    }

    public static function neighboursAreSameColor($player, $a, $board)
    {
        foreach ($board as $b => $st) {
            if (!$st) continue;
            $c = $st[count($st) - 1][0];
            if ($c != $player && self::isNeighbour($a, $b)) return false;
        }
        return true;
    }

    public static function len($tile)
    {
        return $tile ? count($tile) : 0;
    }

    public static function slide($board, $from, $to) {
        // Initial checks remain the same
        if (!self::hasNeighBour($to, $board) || !self::isNeighbour($from, $to)) return false;

        // Adjusting the logic to check for valid sliding conditions more accurately
        $fromCoords = explode(',', $from);
        $toCoords = explode(',', $to);
        $isValidSlide = false;

        foreach (self::$OFFSETS as $offset) {
            $checkX = $toCoords[0] + $offset[0];
            $checkY = $toCoords[1] + $offset[1];
            $checkPos = "$checkX,$checkY";

            // If at least one adjacent position (besides 'from') is unoccupied or is the 'from' position,
            // the piece can 'slide'. Adjusted to allow more flexible movement.
            if (!isset($board[$checkPos]) || $checkPos === $from) {
                $isValidSlide = true;
                break;
            }
        }

        return $isValidSlide;
    }


    public static function belongsToPlayer($pos, $board, $player) {
        if (!isset($board[$pos])) {
            return false;
        }
        $tileStack = $board[$pos];
        $topTile = end($tileStack);
        return $topTile[0] == $player;
    }

    public static function isBoardEmpty($board) {
        foreach ($board as $pos => $tiles) {
            if (!empty($tiles)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Checks if the position is valid for placing or moving a piece.
     *
     * @param string $to The target position.
     * @param array $board The current state of the board.
     * @param int $player The current player (0 or 1).
     * @return bool True if the position is valid, otherwise false.
     */
    public static function isValidPosition($to, $board, $player) {
        // Rule 1: The position must be adjacent to at least one other piece,
        // except for the first move.
        if (!self::hasNeighBour($to, $board) && count($board) > 0) {
            return false;
        }

        // Rule 2: The position must not be occupied.
        if (isset($board[$to])) {
            return false;
        }

        // Rule 3: If it's not the first move, the piece must be adjacent to a friendly piece.
        // This is a simplification and might need adjustment based on Hive's complex rules,
        // especially regarding the Queen Bee and other pieces' unique movement rules.
        if (count($board) > 1 && !self::isNextToFriendlyPiece($to, $board, $player)) {
            return false;
        }

        return true; // Passes all checks
    }

    /**
     * Checks if the position is adjacent to at least one piece belonging to the player.
     *
     * @param string $pos The target position.
     * @param array $board The current state of the board.
     * @param int $player The current player (0 or 1).
     * @return bool True if adjacent to a friendly piece, otherwise false.
     */
    private static function isNextToFriendlyPiece($pos, $board, $player) {
        foreach ($board as $b => $st) {
            if (!$st) continue;
            $c = $st[count($st) - 1][0];
            if ($c == $player && self::isNeighbour($pos, $b)) return true;
        }
        return false;
    }

    public static function validatePlayQueenWithinFourMoves($piece, $hand)
    {
        return $piece != 'Q' && array_sum($hand) <= 8 && $hand['Q'];
    }

    public static function freePositionAfterMove(&$board, $from) {
        if (isset($board[$from])) {
            unset($board[$from]); // Mark the position as free
        }
    }
}
