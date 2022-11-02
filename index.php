<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
error_reporting(-1);

require('application/Application.php');

function router($params)
{
    $method = $params["method"];
    if ($method) {
        $app = new Application();
        switch ($method) {
            case 'check':
                return true;
            case 'login':
                return $app->login($params);
            case 'logout':
                return $app->logout($params);
            case 'sendMessage': 
                return $app->sendMessage($params);
            case 'getMessages': 
                return $app->showChat();
        }
    }
    return null;
}

function answer($data)
{
    if ($data) {
        return array(
            'data' => $data,
            "result" => "ok"
        );
    }
    return array('result' => 'error');
}

echo json_encode(answer(router($_GET)));
