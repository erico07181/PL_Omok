<?php

class Game
{
    public $game_id;
    public $strat;
    public $board;

    function __construct($game_id, $strat, $board)
    {
        $this->game_id = $game_id;
        $this->strat = $strat;
        $this->board = $board;
    }

    function json()
    {
        return json_encode($this);
    }

}

?>