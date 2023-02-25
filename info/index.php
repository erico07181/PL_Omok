<?php

class Info
{
    public $size;
    public $strat;

    function __construct($size, $strat)
    {
        $this->size = $size;
        $this->strat = $strat;
    }
}

$strats = array('Smart' => 'SmartStrategy', 'Random' => 'RandomStrategy');
$GameInfo = new Info(15, array_keys($strats));
echo json_encode($GameInfo);

?>