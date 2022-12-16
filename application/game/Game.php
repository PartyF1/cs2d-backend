<?php
class Game {

    function __construct($db) {
        $this->db = $db;
    }   


    private function updateGamer($gamerId, $player){
        return $this->db->updateGamer($gamerId, $player);
    }

    private function updateGamerWeapon($gamerId, $weapon) {
        if ($weapon)
        return $this->db->updateGamerWeapon($gamerId, $weapon);
    }

    private function updateBullets($gamerId, $gamerMatchId, $bullets){
        return $this->db->updateBullets($gamerId, $gamerMatchId, $bullets);
    }

    private function killPlayer($playerHit){
        if($playerHit)
        return $this->db->killPlayer($playerHit);
    }


    function updateScene(
        $gamerId, 
        $gamerMatchId, 
        $player, 
        $bullets, 
        $playerHit,
        $weapon
    ) {

        $this->updateGamer($gamerId, $player);

        $this->updateGamerWeapon($gamerId, $weapon);

        $this->updateBullets($gamerId, $gamerMatchId, $bullets);

        $this->killPlayer($playerHit);

        return true;
     }
/*
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
        */
   

    function getScene($gamerMatchId){
        return $this->db->getScene($gamerMatchId);
    }
}