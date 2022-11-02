<?php
//header("Access-Control-Allow-Origin: *");
error_reporting(-1);

require('application/Application.php');

 function router ($params) {
    $method = $params['method'];
    if ($method) {
        $app = new Application();
        switch ($method) {
            case 'login' :  return $app->login($params);
            case 'getUserByLogin' :  return $app->getUserByLogin($params);
            case 'sendMessage' : return $app->sendMessage($params);
            case 'getMessages' : return $app->getMessages($params);
        }
    }
}

 function  answer($data) {
    //print_r($data->name);
    if ($data) {
        return array (
            'result' => 'ok',
            'data' => $data
        );
    }
    return array('result' => 'error');
}

echo json_encode(answer(router($_GET)));
