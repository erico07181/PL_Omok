<?php

class Board
{


    public $size;

    public $board;


    public $winner_row = [];

    function __construct($size = 15)
    {
        $this->size = $size;
        $this->board = array_fill(0, $size, array_fill(0, $size, 0));

    }

    static function return_board($pid)
    {
        $game_path = "../data/" . $pid . ".txt";
        $game_file = fopen($game_path, "r") or die("Unable to open");
        $to_json = fread($game_file, filesize($game_path));
        fclose($game_file);
        return self::fromJson($to_json);

    }

    static function fromJson($json)
    {
        $obj = json_decode($json);
        $board = new Board();
        $board->size = $obj->board->size;
        $board->board = $obj->board->board;
        // $board->pid = $obj->game_id;
        // $board->strategy = $obj->strat;
        // $game = new Game($obj->game_id, $obj->strat, $board);
        // return array($board, $game);
        return $board;
    }

    function getTile($x, $y)
    {
        return $this->board[$x][$y];
    }
    function placeTile($x, $y)
    {
        $this->board[$x][$y] = 2;
    }

    function check_board_space()
    {
        foreach ($this->board as $row) {
            foreach ($row as $item) {
                if ($item === 0) {
                    return false;
                }
            }
        }
    }

    function isEmpty($x, $y)
    {
        if ($this->board[$x][$y] != 0) {
            return 1;
        }
        return 0;
    }

    function update_game($game_id, $strategy)
    {
        $path = "../data/" . $game_id . ".txt";
        $file = fopen($path, "w") or die("File is unavailable");
        $json_file = file_get_contents($path);
        $data = json_decode($json_file, true);
        $data['game_id'] = $game_id;
        $data['strat'] = $strategy;
        $data['board'] = $this;
        $json_file = json_encode($data);
        file_put_contents($path, $json_file);
        // fwrite($file, json_encode($this));
        // fwrite($file, json_encode(array("game_id" => $game_id, "strat" => $strategy, $this)));
        // fclose($file);
    }
}

?>