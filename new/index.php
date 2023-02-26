<?php // index.php

include __DIR__ . "/../play/Game.php";
include __DIR__ . "/../play/Board.php";

define('STRATEGY', 'strategy'); // constant
$strategies = ["Smart", "Random"]; // change this later to get 


// $strategies = $_GET['https://cssrvlab01.utep.edu/Classes/cs3360Cheon/earico/info/'];
if (!array_key_exists(STRATEGY, $_GET)) { /* write code here */
    echo json_encode(array("response" => false, "reason" => "Strategy not provided"));
    exit;
}
$strategy = $_GET[STRATEGY];
// write your code here … use uniqid() to create a unique play id.
$game_id = uniqid();


function game_file_store($path, $txt)
{
    $file = fopen('../data/' . $path . ".txt", "w") or die("File does not exist");
    fwrite($file, $txt);
    fclose($file);
}

if (in_array($strategy, $strategies)) {
    $new_board = new Board(15);
    // $new_game = new Game($game_id, $strategy, $new_board);
    // $new_game = new Game()
    // game_file_store($new_game->game_id, json_encode($new_game));
    game_file_store($game_id, json_encode(array("game_id" => $game_id, "strat" => $strategy, "board" => $new_board)));
    echo json_encode(array("response" => "true", "PID" => $game_id));
} else {
    echo json_encode(array("response" => false, "reason" => "Strategy not available"));

}


//Check whether client provided strategy
//If so, check if the strat is available, if not throw error
//if user provides strat, create new game with unique id and return
?>