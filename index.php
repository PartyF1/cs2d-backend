<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:  OPTIONS,GET,POST,PUT,DELETE");
error_reporting(-1);

require('application/Application.php');

 function router ($params) {
    $method = $params['method'];
    
    if ($method) {
        $app = new Application();
        switch ($method) {
            case 'login' :  { return $app->login($params);}
            case 'getUserByToken' :  return $app->getUserByToken($params);
            case 'setGamer' :  return $app->setGamer($params);
            case 'getElementById' :  return $app->getElementById($params); 
            case 'convert' : return $app->convert($params);
            case 'sendMessage' : return $app->sendMessage($params);
            case 'getMessages' : return $app->getMessages($params);
            case 'registration' : return $app->registration($params);
            //Lobby
            case 'createLobby' : return $app->createLobby($params);
            case 'startMatch' : return $app->startMatch($params);
            case 'joinToLobby' : return $app->joinToLobby($params);
            case 'leaveLobby' : return $app->leaveLobby($params);
            case 'getUsersInLobby' : return $app->getUsersInLobby($params);
            case 'getGamer' :  { return $app->getGamer($params);}
            case 'getAllLobby' : return $app->getAllLobby($params);
            case 'deleteLobby' : return $app->deleteLobby($params);
            //inventory
            case 'getInventory' : return $app->getInventory($params);
            case 'setArms' : return $app->setArms($params);
            //game
            case 'updateScene' : {return $app->updateScene();}
            case 'getScene' : {return $app->getScene($params);}
        }
    }
}

 function  answer($data) {
    //print_r($data);
    if ($data) {
        return array (
            'result' => 'ok',
            'data' => $data
        );
    }
    return array('result' => 'error');
}

echo json_encode(answer(router($_GET)));

