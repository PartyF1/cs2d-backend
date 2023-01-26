<?php
class Match {

    function __construct($db) {
        $this->db = $db;
    }

    function createLobby($token, $mode, $map, $maxAmountPlayers){
        return $this->db->createLobby($token, $mode, $map, $maxAmountPlayers);
    }

    function startMatch($token, $lobbyId, $lobbyOwnerId, $lobbyAmountPlayers, $mode, $map) {
       // print_r($token+ $lobbyId+$lobbyOwnerId+ $lobbyAmountPlayers+ $mode+ $map);
        return $this->db->startMatch($token, $lobbyId, $lobbyOwnerId, $lobbyAmountPlayers, $mode, $map);   
    }

    function joinToLobby($lobbyId, $token){
        return $this->db->joinToLobby($lobbyId, $token);
    }

    function leavelobby($lobbyId, $token){
        return $this->db->leavelobby($lobbyId, $token);
    }

    function getUsersInLobby($lobbyId, $token){
        return $this->db->getUsersInLobby($lobbyId, $token);
    }

    function deleteLobby($token){
        //print_r($token);
        return $this->db->deleteLobby($token);
    }
    
    function getAllLobby(){
        
        return $this->db->getAllLobby();
    }

    function leaveMatch($gamerId, $matchId){
        return $this->db->leaveMatch($gamerId, $matchId);
    }
}