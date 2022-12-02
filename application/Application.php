<?php

require('db/DB.php');
require('user/User.php');
require('convert/Convert.php');
require('chat/Chat.php');
require('match/Match.php');
require('gamer/Gamer.php');
require('game/Game.php');
require('inventory/Inventory.php');

class Application {
    function __construct() {
        $db = new DB();
        $this->user = new User($db);
        $this->chat = new Chat($db);
        $this->inventory = new Inventory($db);
        $this->match = new Match($db);
        $this->gamer = new Gamer($db);
        $this->game = new Game($db);
        $this->convertModule = new Convert();
    }

function login($params) {
    if ($params['login'] && $params['password']) {
        return $this->user->login($params['login'], $params['password']);
    };
}

function registration($params){
    return $this->user->registration($params['userName'], $params['password'], $params['login']);
}


function getUserByToken($params) {
    
    if ($params['token']) {
        return $this->user->getUserByToken($params['token']);
    };
}

function setGamer($params) {
    
    if ($params['token']) {
        return $this->user->setGamer($params['token']);
    };
}

function getElementById($params) {
   
    if ($params['element'] && $params['id']) {
        return $this->user->getElementById($params['element'], $params['id']);
    };
}

function convert($params) {
    $user = $this->user->getUser($params['token']);
    if ($user && $params['value'] && $params['systemFrom'] && $params['systemTo']) 
        return $this->convertModule->convertTo($params['value'] , $params['systemFrom'] , $params['systemTo']);
    
}

function sendMessage($params) {
    if ($params['message']) 
        return $this->chat->sendMessage($params['id'], $params['name'] , $params['message']);   
}


function getMessages($params) {
        return $this->chat->getMessages($params['hash']);   
}

function createLobby($params) {
    return $this->match->createLobby($params['token'], $params['mode'], $params['map'], $params['amountPlayers']);   
}

function startMatch($params) {
    return $this->match->startMatch($params['token'], $params['lobbyId'], $params['lobbyOwnerId'], $params['lobbyAmountPlayers'], $params['mode'], $params['map'] );   
}

//Inventory
function setArms($params) {
    return $this->inventory->setArms($params['weapon'], $params['userId']);
}

function getInventory($params) {
    return $this->inventory->getInventory($params['userId']);
}

function joinToLobby($params) { 
    return $this->match->joinToLobby($params['lobbyId'], $params['token']);
}

function leaveLobby($params) { 
    return $this->match->leaveLobby($params['lobbyId'], $params['token']);
}

function getUsersInLobby($params) {
    return $this->match->getUsersInLobby($params['lobbyId'], $params['token']);
}

function deleteLobby($params) {
    //print_r($params);
   // $ownerId = getUserByToken($params);
   // print_r($ownerId);
    return $this->match->deleteLobby($params['token']);
}

function getAllLobby($params) {
    //print_r($params['token']);
    if ($params['token'])
        return $this->match->getAllLobby();
}

function getGamer($params) {
    if ($params['token'])
        return $this->gamer->getGamer($params['token']);
}

function updateScene($params) {
    //print_r($params['X']);
        return $this->game->updateScene($params['token'], $params['X'], $params['Y']);
}
}