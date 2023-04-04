<?php

class User {
   
    function __construct($db){
        $this->db = $db;
        }
       

        function login($login, $password) { 
            $user = $this->db->getUser($login); 
            if ($login && $password == $user->password) {
                $token = md5(rand());
                $this->db->updateToken($user->id, $token);
                $this->db->resetGamer($user->id);
                return array (
                    'name' => $user->name,
                    'token' => $token
                );
            }
            
        }
    
        function registration($userName, $password, $login){
            $this->db->registration($userName, $password, $login);
            }


        function getUserByToken($token){
            $user = $this->db->getUserByToken($token);
                return $user;
            }

            function setGamer($token){
                $user = $this->db->setGamer($token);
                return true;
                }


            function getElementById($element, $id){
                
                $user = $this->db->getElementById($element, $id);
                    return $user;
                }

        function getUser($token) {
            return !!$token;
        }

        function getAllRecords($tableName) {
            return $this->db->getAllRecords($tableName);
        }
}