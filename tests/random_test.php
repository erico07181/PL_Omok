<?php

include __DIR__ . "/../play/Game.php";
include __DIR__ . "/../play/Board.php";
include __DIR__ . "/../play/RandomStrategy.php";

test();

function test()
{
    $board = new Board();
    echo $board->isEmpty(5, 4);

    $strategy = new RandomStrategy($board);
    $place = $strategy->pickPlace($board);
    echo $board->isEmpty(5, 4);
    echo "\n";
    var_dump($place);
}



?>