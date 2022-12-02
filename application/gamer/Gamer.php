<?php
class Gamer {

    function __construct($db) {
        $this->db = $db;
    }   

    function getGamer($token) {
        return $this->db->getGamer($token);
    }
}