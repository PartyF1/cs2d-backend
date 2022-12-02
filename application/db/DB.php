<?php
class DB {
    function __construct()  {
        $host = 'localhost';
        $port = '3306';
        $name = 'my'; // db name
        $user = 'root'; // user name
        $pass = ''; // user password
        try {
            $this->db = new PDO(
                'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $name,
                $user,
                $pass
            );
        } catch(Exception $e) { 
            print_r(" не удалось подлкючиться к БД");
            die();
        }
    }

    function __destruct() {
        $this->db = null;
    }

    private function getArray($query) {
        $count = 0;
        $stmt = $this->db->query($query);
        $result = array();
         while($row = $stmt->fetchObject()) {
            $result[] = $row;
            $count++;
         }

        return $result;
    }

    public function getUser($login) {
        $query = 'SELECT * FROM users WHERE login="' . $login . '"';
        return $this->db->query($query)->fetchObject();
    }

    public function getUserByToken($token) {
        $query = 'SELECT * FROM users WHERE token="' . $token . '"';
        return $this->db->query($query)->fetchObject();
    }

    public function setGamer($token) {
        $user = $this->getUserByToken($token);
        $userId = $user->id;
        $gamerName =$user->name;
        $characterId = 0;
        $arms = 0;
        $backpack = 0;
        
        $query = "INSERT INTO `gamers`(`id`, `userId`, `gamerName` ,`characterId`, `arms`, `backpack`, `score`, `X`, `Y`, `lobbyId`, `matchId`) 
        VALUES(" ."null".  "," .
                $userId .  ",'" .
                $gamerName .  "'," .
            $characterId.  "," .
                   $arms.  "," .
               $backpack.  "," . 
                     666 .  "," . 
                     0 . "," . 
                     0 . "," .
                  "null".  "," .
                 "null" .  ")";  
                 //print_r($query);      
        $this->db->query($query);
        return true;
    }

    public function getElementById($element, $id) {
        $query = 'SELECT * FROM ' . $element . ' WHERE id="' . $id . '"';
       return $this->db->query($query)->fetchObject();
    }

    public function updateToken($id, $token) {
        $query = 'UPDATE users SET token="' . $token . '" WHERE id=' . $id;
        $this->db->query($query);
        return true;
    }

    public function sendMessage($userId, $name, $message){
        $query = "INSERT INTO `message`(`id`, `message`, `userName`) VALUES(" ."null".  ",'" .  $message .  "','" . $name."')";
        $this->db->query($query);
        return true;
    }

    public function getMessages() {
        $query = 'SELECT * FROM `message` ';
        return $this->getArray($query);
    }

    public function getChatHash() {
        $query = 'SELECT chat_hash FROM statuses';
        return $this->db->query($query)->fetchObject();
    }

    public function setChatHash($hash) {
        $query = 'UPDATE statuses SET chat_hash="' . $hash . '"';
        $this->db->query($query);
        return true;
    }

    public function getUsers() {
        $query = 'SELECT * FROM users';
        return $this->getArray($query);
    }

    public function registration($userName, $password, $login){
        $query = "INSERT INTO `users`(`id`, `login`, `password`, `token`, `name`)
         VALUES(" . "null" . ",'" . $login . "','" . $password . "'," . "null" . ",'" . $userName ."')";
        $this->db->query($query);
        return true;
        }

    public function getInventory($token) {
        $userId = $this->getUserByToken($token)->id;
        $query = 'SELECT `backpack` FROM `gamers` WHERE `userId` ='. $userId;
        return $this->db->query($query)->fetchObject();
    }
    
    public function setArms($weapon,$token) {
        $userId = $this->getUserByToken($token)->id;
        $query = 'UPDATE `gamers` SET `arms`='."'".$weapon."'".' WHERE `usersId` ='. $userId;
        $this->db->query($query);
        return true;
    }

    public function createLobby($token, $mode, $map, $maxAmountPlayers) {
        $owner = $this->getUserByToken($token);
        $ownerId = $owner->id; 
        $ownerName = $owner->name;
        
        $query = "INSERT INTO `lobby`(`id`, `ownerId`,`ownerName`, `amountPlayers`, `maxAmountPlayers`, `mode`, `map`)
         VALUES(" . "null" .  "," .  
                  $ownerId .  ", '" . 
                  $ownerName.  "',".
                          1 .  "," .
          $maxAmountPlayers.  ",'" .
                    $mode .  "','" .
                    $map .   " ')";
        $this->db->query($query);

        $query = 'SELECT `id` FROM `lobby` WHERE ownerId='.$ownerId;
        $lobbyId = $this->db->query($query)->fetchObject()->id; 
        $this->db->query('UPDATE `gamers` SET lobbyId=' . $lobbyId . ' WHERE userId=' . $ownerId);
        return $lobbyId;
    }

    public function startMatch($token, $lobbyId, $lobbyOwnerId, $lobbyAmountPlayers, $mode, $map) {
       $a = 0;
       $query = "INSERT INTO `matches`(`id`, `ownerId`, `amountPlayers`, `time`, `endConditional`, `map`, `status`, `timestemp`)
        VALUES(" . "null" .  "," .  
                 $lobbyOwnerId .  "," . 
                 $lobbyAmountPlayers.  ",".
                 $a.  "," .
                 $a.  ",'" .
                   $map .  "','" .
                   "open" .  "'," .
                   $a.   " )";
        $this->db->query($query);

        $query = 'SELECT `id` FROM `matches` WHERE ownerId = ' . $lobbyOwnerId;
        $matchId = $this->db->query($query)->fetchObject()->id;
        $query = 'UPDATE `gamers` SET `lobbyId`='. "null". ',`matchId`= '. $matchId .' WHERE `lobbyId` ='. $lobbyId;
        $matchId = $this->db->query($query);
       
        $query = 'DELETE FROM `lobby` WHERE `ownerId` ='.$lobbyOwnerId;
         $this->db->query($query);

                   return true;          
    }

    public function joinToLobby($lobbyId, $token) {
        print_r($lobbyId, $token);
        $userId = $this->getUserByToken($token)->id;

        $query = 'UPDATE `gamers` SET `lobbyId`='. $lobbyId .' WHERE `userId` ='. $userId;
        $this->db->query($query);
        $query = 'UPDATE `lobby`   SET `amountPlayers` = `amountPlayers` +  1  WHERE `id` = '. $lobbyId; 
        $this->db->query($query);
        
        return true;
    }

    public function leaveLobby($lobbyId, $token) {
        $userId = $this->getUserByToken($token)->id;

        $query = 'UPDATE `gamers` SET `lobbyId`='. "null" .' WHERE `userId` ='. $userId;
        $this->db->query($query);
        $query = 'UPDATE `lobby`   SET `amountPlayers` = `amountPlayers` -  1  WHERE `id` = '. $lobbyId; 
        $this->db->query($query);

        return true;
    }

    public function getUsersInLobby($lobbyId, $token){
        $stmt = $this->db->query('SELECT * FROM `gamers` ');
        $result = array();
         while($row = $stmt->fetchObject()) {
            if($row->lobbyId == $lobbyId)
            $result[] = $row;
        }
        return $result; 
    }

    public function deleteLobby($token){
        $ownerId = $this->getUserByToken($token)->id;
         
         $query = 'DELETE FROM `lobby` WHERE `ownerId` ='.$ownerId;
         $this->db->query($query);
         return true;
     }

    public function getAllLobby(){
        $query = 'SELECT lobby.id, lobby.ownerId, lobby.ownerName, lobby.amountPlayers, lobby.maxAmountPlayers, lobby.mode, lobby.map,
        
         GROUP_CONCAT(gamers.gamerName) AS players
         FROM (`lobby` LEFT JOIN `gamers` ON lobby.id = gamers.lobbyId)
         GROUP BY lobby.id';
         $query = $this->getArray($query);
         if ($query) {
            return $query;
         } else {
            return ["hi"];
         }
    }

    public function getGamer($token) {
        $gamerId = $this->getUserByToken($token)->id;

        $query = 'SELECT * FROM `gamers` WHERE userId='.$gamerId;
        return $query = $this->getArray($query);
    }

    public function updateScene($token, $X, $Y) {


        $userId = $this->getUserByToken($token)->id;
        $query = 'SELECT * FROM `gamers` WHERE userId='.$userId;
        
        $gamer = $this->db->query($query)->fetchObject();
        
        $gamerId = $gamer->id;
        $matchId = $gamer->matchId;
        
        $query = 'UPDATE `gamers` SET `X`='. $X . ',`Y`= '. $Y .' WHERE `id` ='. $gamerId;
        $this->db->query($query);
        $stmt = $this->db->query('SELECT * FROM `gamers` ');
        $result = array();
        while($row = $stmt->fetchObject()) {
        if(($row->matchId == $matchId) && ($row->userId != $userId))
        $result[] = $row;
        }
        
        return $result;
        }
}

