<?php

include __DIR__ . "/Game.php";
include __DIR__ . "/Board.php";
include __DIR__ . "/Move.php";


define('PID', 'pid');
define('STRATEGY', 'strategy');
define('MOVE', 'move');
define('DATA_DIR', '../data/');
define('DATA_EXT', '.txt');

class Response
{
    public $res;
    public $player_move;
    public $computer_move;

    function __construct($response, $player_move, $computer_move)
    {
        $this->res = $response;
        $this->player_move = $player_move;
        $this->computer_move = $computer_move;

    }
}

class Index
{
    public $board;
    public $game;
    public $requested_x;
    public $requested_y;
    public $response_x;
    public $response_y;

    function check_pid()
    {
        if (!array_key_exists(PID, $_GET)) {
            echo json_encode(array("Reponse" => "false", "Reason" => "PID not specified"));
            exit;
        }
        $pid_files = scandir(DATA_DIR);
        if (!in_array($_GET[PID] . DATA_EXT, $pid_files)) {
            echo json_encode(array("Reponse" => "false", "Reason" => "PID not available"));
            exit;
        }
    }

    public function check_move()
    {

        if (!array_key_exists(MOVE, $_GET)) {
            echo json_encode(array("Reponse" => "false", "Reason" => "Invalid Move"));
            exit;
        }
        $move_coords = Index::string_to_coords($_GET['move']);
        $this->requested_x = intval($move_coords[0]);
        $this->requested_y = intval($move_coords[1]);
    }

    public function check_stone()
    {
        $this->board = Board::return_board($_GET[PID]);
        if ($this->board->board[$this->requested_x][$this->requested_y] != 0) {
            echo json_encode(array("Reponse" => "false", "Reason" => "Coordinate contains Stone"));
            exit;
        }
    }

    function check_if_coords_in_range($x, $y)
    {
        if ($x > 14 || $x < 0) {
            echo json_encode(array("Response" => "false", "Reason" => "x coord out of range"));
            exit;
        }
        if ($y > 14 || $y < 0) {
            echo json_encode(array("Response" => "false", "Reason" => "y coord out of range"));
            exit;
        }

    }

    function string_to_coords($move)
    {
        $move_list = explode(",", $move);
        if (sizeof($move_list) != 2) {
            echo json_encode(array("Response" => "false", "Reason" => "Invalid move"));
            exit;
        }
        $this->check_if_coords_in_range($move_list[0], $move_list[1]);
        return $move_list;
    }

    function send_json_response()
    {
        $player_move = new Move($this->requested_x, $this->requested_y, $this->game->hasWon(1), $this->board->check_board_space(), $this->game->player_row1());
        $comp_move = new Move($this->response_x, $this->response_y, $this->game->hasWon(2), $this->board->check_board_space(), $this->game->player_row2());

        $res = new Response(true, $player_move, $comp_move);
        echo json_encode($res);
    }

    function start()
    {

        $this->check_pid();
        $this->check_move();
        $this->check_stone();


        $this->game = new Game($_GET['pid'], $_GET['strategy'], $this->board);
        // echo (json_encode($this->game));
        $this->game->user_move($this->requested_x, $this->requested_y);

        if ($this->board->check_board_space()) {
            Index::send_json_response();
            exit;
        }

        $move_coords = $this->game->computer_move();
        $this->response_x = $move_coords[0];
        $this->response_y = $move_coords[1];
        $this->board->board[$this->response_x][$this->response_y] = 2;
        $this->board->update_game($this->game->game_id, $this->game->strat);
        Index::send_json_response();

    }


}

$index = new Index();
$index->start();

?>