<?php

include __DIR__ . "/MoveStrategy.php";
class RandomStrategy extends MoveStrategy
{
    function __construct($board)
    {
        parent::__construct($board);
    }
    public function pickPlace(Board $board)
    {
        $isAvailableTile = false;
        while (!$isAvailableTile) {
            $x = rand(0, 14);
            $y = rand(0, 14);

            if ($board->getTile($x, $y) == 0) {
                //Change so it keeps track of current player
                $board->placeTile($x, $y);

                $isAvailableTile = true;
            }

        }
        return array($x, $y);


    }

}

?>