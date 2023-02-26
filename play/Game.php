<?php


require_once('SmartStrategy.php');
require_once('RandomStrategy.php');
class Game
{
    public $game_id;
    public $strategies;

    public $strat;
    public $board;

    function __construct($game_id, $strat, $board)
    {
        $this->game_id = $game_id;
        $this->strat = $strat;
        $this->board = $board;
        $this->strategies = array('Smart' => 'SmartStrategy', "Random" => "RandomStrategy");

    }


    function user_move($x, $y)
    {
        $this->board->board[$x][$y] = 1;
        $this->board->update_game($this->game_id, $this->strat);
    }

    function computer_move()
    {
        $strategy = new $this->strategies[$this->strat]($this->board);
        return $strategy->pickPlace($this->board);
    }

    // function player1_row() {
    //     if (!$this->board->player)
    // }


    function hasWon($player)
    {
        $this->vertical($player);
        $this->horizontal($player);
        $this->diagonal($player);
        return sizeof($this->board->winner_row) == 10;
    }

    private function diagonal($player)
    {
        for ($i = 2; $i < $this->board->size - 3; $i++) {
            for ($j = 2; $j < $this->board->size - 3; $j++) {
                $diagonal_row = $this->get_row($i, $j, 1, 1);
                if ($this->check_array($diagonal_row, $player)) {
                    $this->board->winner_row = [];
                    array_push(
                        $this->board->winner_row,
                        $i - 2, $j - 2,
                        $i - 1, $j - 1,
                        $i,
                        $j,
                        $i + 1, $j + 1,
                        $i + 2, $j + 2
                    );
                }
                $negative_diagonal = $this->get_row($i, $j, 1, -1);
                if ($this->check_array($negative_diagonal, $player)) {
                    $this->board->winner_row = [];

                    array_push(
                        $this->board->winner_row,
                        $i + 2, $j - 2,
                        $i + 1, $j - 1,
                        $i,
                        $j,
                        $i - 1, $j + 1,
                        $i - 2, $j + 2
                    );
                }

            }

        }
    }

    private function vertical($player)
    {
        for ($i = 0; $i < $this->board->size; $i++) {
            for ($j = 2; $j < $this->board->size - 3; $j++) {
                $vertical_row = $this->get_row($i, $j, 0, 1);
                if ($this->check_array($vertical_row, $player)) {
                    $this->board->winner_row = [];
                    array_push($this->board->winner_row, $i, $j - 2, $i, $j - 1, $i, $j, $i, $j + 1, $i, $j + 2);
                }
            }
        }
    }

    private function horizontal($player)
    {
        for ($i = 2; $i < $this->board->size - 3; $i++) {
            for ($j = 0; $j < $this->board->size; $j++) {
                $col = $this->get_row($i, $j, 1, 0);
                if ($this->check_array($col, $player)) {
                    $this->board->winner_row = [];
                    array_push(
                        $this->board->winner_row, $i - 0,
                        $j, $i - 1,
                        $j,
                        $i,
                        $j, $i + 1,
                        $j, $i + 2,
                        $j
                    );
                }
            }
        }
    }

    function get_row($x, $y, $difference_x, $difference_y)
    {
        $row = array();
        for ($i = -2; $i < 3; $i++) {
            // echo (json_encode($i . " "));
            if ($x + $difference_x * $i == 15 || $y + $difference_y * $i == 15) {
                echo (json_encode($x + $difference_x * $i . " "));
                echo (json_encode($y + $difference_y * $i . " "));
                echo (json_encode($this->board->board[$x + $difference_x * $i][14]));
            }

            array_push($row, $this->board->board[$x + $difference_x * $i][$y + $difference_y * $i]);
        }
        return $row;
    }

    function check_array($array, $ele)
    {
        foreach ($array as $num) {
            if ($num != $ele) {
                return false;
            }
        }
        return true;
    }

    // function player_row($player_num)
    // {
    //     if ($player_num == 1) {
    //         if (!$this->hasWon($player_num)) {
    //             return [];
    //         }
    //         if (count($this->board->winner_row) === 0) {
    //             return [];
    //         }
    //         return $this->board->winner_row;
    //     }
    //     if ($player_num == 2) {
    //         if (!$this->hasWon($player_num)) {
    //             return [];
    //         }
    //         if (count($this->board->winner_row) === 0) {
    //             return [];
    //         }
    //         return $this->board->winner_row;
    //     } else {
    //         echo json_encode(array("Response" => "false", "Reason", "Player number is not valid"));
    //         exit;
    //     }

    // }

    function player_row1()
    {
        if (!$this->hasWon(1)) {
            return [];
        }
        if (count($this->board->winner_row) === 0) {
            return [];
        }
        return $this->board->winner_row;
    }

    function player_row2()
    {
        if (!$this->hasWon(2)) {
            return [];
        }
        if (count($this->board->winner_row) === 0) {
            return [];
        }
        return $this->board->winner_row;
    }


}

?>