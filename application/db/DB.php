<?php
class DB {
    function __construct()  {
        $host = 'localhost';
        $port = '3306';
        $name = 'cs2d'; // db name
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
        return ( $this->db->query($query)->fetchObject());
    }

    public function setGamer($token) {
        $user = $this->getUserByToken($token);
        $userId = $user->id;
        $gamerName =$user->name;
        $characterId = 0;
        $arms = 0;
        $backpack = 0;
        
        $query = "INSERT INTO `gamers` (`id`, `userId`, `gamerName`, `characterId`, `score`, `X`, `Y`, `weapon`, `weaponX`, `weaponY`,
        `weaponRotation`, `weaponFlipY`, `lobbyId`, `matchId`, `statusInMatch`)
        VALUES(" ."null". "," .
        $userId . ",'" .
        $gamerName . "'," .
        $characterId. "," .
        "666". "," .
        "0". "," .
        "0". "," .
        "0". "," .
        "0". "," .
        "0". "," .
        "0". "," .
        "0". "," .
        "null". "," .
        "null" . "," .
        "0" . ")" ;
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
        //print_r($query);
        $matchId = $this->db->query($query);
       
        $query = 'DELETE FROM `lobby` WHERE `id` ='.$lobbyId;
        //print_r($query);
         $this->db->query($query);

                   return true;          
    }

    public function joinToLobby($lobbyId, $token) {
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
         return $query;
    }

    public function getGamer($gamerId) {

        $query = 'SELECT * FROM `gamers` WHERE userId='.$gamerId;
        return $this->db->query($query)->fetchObject();
    }


    public function updateScene($gamerId, $gamerMatchId, $x, $y, $weapon, $weaponRotation, $weaponFlipY, $weaponY, $weaponX, $bullets, $playerHit) {

        // обновляем координаты и оружие игрока
        $query = 'UPDATE `gamers` SET `X`='. $x . ',`Y`= '. $y . ',`weaponRotation`= '. $weaponRotation . ',`weapon`= '. $weapon . ',`weaponFlipY`= '. $weaponFlipY . ',`weaponX`='. $weaponX . ',`weaponY`= '. $weaponY .' WHERE `id` ='. $gamerId;
      // print_r($query);
         $this->db->query($query);


            // удаляем массив старых пуль
        $query = 'DELETE FROM `bullets` WHERE `gamerId` ='.$gamerId;
        $this->db->query($query);

        // добавляем массив текущих пуль
        // forEach bullet.x bullet.y - цикл по всем пулям
        for($i = 0; $i<$bullets.end(); $i++)
        {$query = $query = "INSERT INTO `bullets`(`id`, `gamerId`, `matchId`, `x`, `y`, `rotation`) VALUES(" .
         "null" .  "," . $gamerId  .  "," .  $gamerMatchId . "," . $bullets[$i]->x . ",". $bullets[$i]->y . ",". $bullets[$i]->rotation . ")";
         $this->db->query($query);}
       
         $query = 'UPDATE `gamers` SET `statusInMatch`=' . 0 .'WHERE `id`='.$playerHit;
         $this->db->query($query);
        return $result;
        }



        public function getScene($gamerMatchId) {
        
            
        // массив игроков
        $query = 'SELECT * FROM `gamers`WHERE matchId = '.$gamerMatchId. ' AND `statusInMatch` = 1';
        $gamers = $this->getArray($query);
          
          //массив пуль
        $query = 'SELECT * FROM `bullets` WHERE matchId = '.$gamerMatchId;
        $bullets = $this->getArray($query);
       

        $array = array(
            "gamers" => $gamers,
            "bullets" => $bullets,
        );

        return $array;
        }

}

