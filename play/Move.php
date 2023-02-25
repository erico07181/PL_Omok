<?php

class Move
{
    public $x;
    public $y;
    public $didWin;
    public $didDraw;
    public $row;

    function __construct($x, $y, $didWin, $didDraw, $row)
    {
        $this->x = $x;
        $this->y = $y;
        $this->didWin = $didWin;
        $this->didDraw = $didDraw;
        $this->row = $row;
    }
}

?>