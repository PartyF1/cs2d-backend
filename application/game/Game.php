<?php
class Game {

    function __construct($db) {
        $this->db = $db;
    }   

    function updateScene($gamerId, $gamerMatchId, $player, $bullets, $playerHit) {
        
        return $this->db->updateScene(
            $gamerId, 
            $gamerMatchId, 
            $player->body->center->x,
            $player->body->center->y,
            $player->weapon->name,
            $player->weapon->rotate,
            $player->weapon->flipY,
            $player->weapon->x,
            $player->weapon->y,
            $bullets,
            $playerHit
        );
    }

    function getScene($gamerMatchId){
        return $this->db->getScene($gamerMatchId);
    }
}