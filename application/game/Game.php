<?php
class Game
{

    function __construct($db)
    {
        $this->db = $db;
    }


    private function updateGamer($gamerId, $player, $statusInMatch)
    {
        return $this->db->updateGamer($gamerId, $player, $statusInMatch);
    }

    private function updateGamerWeapon($gamerId, $weapon)
    {
        if ($weapon)
            return $this->db->updateGamerWeapon($gamerId, $weapon);
    }

    private function updateBullets($gamerId, $gamerMatchId, $bullets)
    {
        return $this->db->updateBullets($gamerId, $gamerMatchId, $bullets);
    }

    private function killPlayer($playerHit, $player)
    {
        if ($playerHit)
            return $this->db->killPlayer($playerHit, $player);
    }

    private function updateSceneHash($gamerMatchId)
    {
        return $this->db->updateSceneHash($gamerMatchId);
    }

    private function checkEnd($gamerMatchId) {
        return $this->db->checkEnd($gamerMatchId);
    }


    function updateScene(
        $gamerId,
        $gamerMatchId,
        $player,
        $bullets,
        $playerHit,
        $weapon,
        $statusInMatch
        ) {
        
        $this->updateGamer($gamerId, $player, $statusInMatch);
        
        $this->updateGamerWeapon($gamerId, $weapon);
        
        $this->updateBullets($gamerId, $gamerMatchId, $bullets);
        
        $this->killPlayer($playerHit, $gamerId);
        
        $this->updateSceneHash($gamerMatchId);
        
        $this->checkEnd($gamerMatchId);
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


    function getScene($gamerMatchId, $sceneHash)
    {
        return $this->db->getScene($gamerMatchId, $sceneHash);
    }
}
