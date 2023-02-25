<?php

class Board
{
    public $size;

    public $board;

    public $winner_row = [];

    function __construct($size = 15)
    {
        $this->size = $size;
        $this->board = array_fill(0, $size, array_fill(0, $size, "-"));

    }

    function getTile($x, $y)
    {
        return $this->board[$x][$y];
    }
    function placeTile($player, $x, $y)
    {
        if ($player == 2) {
            $this->board[$x][$y] = "X";
        } else {
            $this->board[$x][$y] = "O";
        }

    }
    function isEmpty($x, $y)
    {
        if ($this->board[$x][$y] == '-') {
            return 1;
        }
        return 0;
    }
}

?>