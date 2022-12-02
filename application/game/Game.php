<?php
class Game {

    function __construct($db) {
        $this->db = $db;
    }   

    function updateScene($token, $X, $Y) {
        //print_r($token);
        return $this->db->updateScene($token, $X, $Y);
    }
}