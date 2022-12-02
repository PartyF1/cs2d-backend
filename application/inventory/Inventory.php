<?php

class Inventory {

    function __construct($db) {
        $this->db = $db;
    }
    
    function getInventory($userId){
        //print_r($this->db->getInventory($userId));
        return $this->db->getInventory($userId);
    }

    
    function setArms($weapon,$userId) {
       // print_r($this->inventory->setArms($weapon,$userId));
        return $this->db->setArms($weapon,$userId);
    }

}