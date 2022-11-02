<?php
require('db/DB.php');
require('user/User.php');

class Application {
    function __construct() {
        $db = new DB();
        $this->user = new User($db);
    }

    function login($params) {
        if ($params['login'] && $params['password']) {
            return $this->user->login($params['login'], $params['password']);
        }
    }

    function logout($params) {
        if ($params['token']) { 
            return $this->user->logout($params['token']);
        }
    }

    function sendMessage($params) {
        if ($params['message'] && $params["name"]) 
            return $this->user->sendMessage($params['name'], $params['message']);   
    }
    
    function showChat() {    
        return $this->user->showChat();   
    }
}