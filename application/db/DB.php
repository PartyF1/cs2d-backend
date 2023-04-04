<?php
class DB
{
    function __construct()
    {
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
        } catch (Exception $e) {
            print_r(" не удалось подлкючиться к БД");
            die();
        }
    }

    function __destruct()
    {
        $this->db = null;
    }

    private function getArray($query)
    {
        $count = 0;
        $stmt = $this->db->query($query);
        $result = array();
        while ($row = $stmt->fetchObject()) {
            $result[] = $row;
            $count++;
        }
        return $result;
    }

    public function getUser($login)
    {
        $query = 'SELECT * FROM users WHERE login="' . $login . '"';
        return $this->db->query($query)->fetchObject();
    }

    public function getUserByToken($token)
    {
        $query = 'SELECT * FROM users WHERE token="' . $token . '"';
        return ($this->db->query($query)->fetchObject());
    }



    public function getElementById($element, $id)
    {
        $query = 'SELECT * FROM ' . $element . ' WHERE id="' . $id . '"';
        return $this->db->query($query)->fetchObject();
    }

    public function updateToken($id, $token)
    {
        $query = 'UPDATE users SET token="' . $token . '" WHERE id=' . $id;
        $this->db->query($query);
        return true;
    }

    public function sendMessage($userId, $name, $message)
    {
        $query = "INSERT INTO `message`(`id`, `message`, `userName`) VALUES(" . "null" .  ",'" .  $message .  "','" . $name . "')";
        $this->db->query($query);
        return true;
    }

    public function getMessages()
    {
        $query = 'SELECT * FROM `message` ';
        return $this->getArray($query);
    }

    public function getChatHash()
    {
        $query = 'SELECT chat_hash FROM statuses';
        return $this->db->query($query)->fetchObject();
    }

    public function setChatHash($hash)
    {
        $query = 'UPDATE statuses SET chat_hash="' . $hash . '"';
        $this->db->query($query);
        return true;
    }

    public function getUsers()
    {
        $query = 'SELECT * FROM users';
        return $this->getArray($query);
    }

    public function resetGamer($userId)
    {
        $query = 'UPDATE gamers SET 
                                    X = 0, 
                                    Y = 0, 
                                    matchId= ' . 'null' . 
                                    ', lobbyId= ' . 'null' .
                                    ',statusInMatch="alive", 
                                    deaths= ' . 0 .
                                    ',kills= ' . 0 .
                                    ' WHERE userId= ' . $userId;
        $this->db->query($query);
    }

    public function registration($userName, $password, $login)
    {
        $query = "INSERT INTO `users`(`id`, `login`, `password`, `token`, `name`)
         VALUES(" . "null" . ",'" . $login . "','" . $password . "'," . "null" . ",'" . $userName . "')";
        $this->db->query($query);
        $user = $this->getUser($login);
        $query = "INSERT INTO `gamers` (`id`, `userId`, `gamerName`, `characterId`, `score`, `X`, `Y`, `weapon`, `weaponX`, `weaponY`,
        `weaponRotation`, `lobbyId`, `matchId`, `statusInMatch`)
        VALUES(" . "null" . "," .
            $user->id . ",'" .
            $user->name . "'," .
            "0" . "," .
            "666" . "," .
            "0" . "," .
            "0" . "," .
            "0" . "," .
            "0" . "," .
            "0" . "," .
            "0" . "," .
            "null" . "," .
            "null" . "," .
            "'alive'" . ")";
        //print_r($query);
        $this->db->query($query);
        return true;
    }

    /*public function setGamer($token)
    {
        $user = $this->getUserByToken($token);
        $userId = $user->id;
        $gamerName = $user->name;
        $characterId = 0;
        $arms = 0;
        $backpack = 0;

        $query = "INSERT INTO `gamers` (`id`, `userId`, `gamerName`, `characterId`, `score`, `X`, `Y`, `weapon`, `weaponX`, `weaponY`,
        `weaponRotation`, `lobbyId`, `matchId`, `statusInMatch`)
        VALUES(" . "null" . "," .
            $userId . ",'" .
            $gamerName . "'," .
            $characterId . "," .
            "666" . "," .
            "0" . "," .
            "0" . "," .
            "0" . "," .
            "0" . "," .
            "0" . "," .
            "0" . "," .
            "null" . "," .
            "null" . "," .
            "1" . ")";
        //print_r($query);
        $this->db->query($query);
        return true;
    }*/


    public function getInventory($token)
    {
        $userId = $this->getUserByToken($token)->id;
        $query = 'SELECT `backpack` FROM `gamers` WHERE `userId` =' . $userId;
        return $this->db->query($query)->fetchObject();
    }

    public function setArms($weapon, $token)
    {
        $userId = $this->getUserByToken($token)->id;
        $query = 'UPDATE `gamers` SET `arms`=' . "'" . $weapon . "'" . ' WHERE `usersId` =' . $userId;
        $this->db->query($query);
        return true;
    }

    public function createLobby($token, $mode, $map, $maxAmountPlayers)
    {
        $owner = $this->getUserByToken($token);
        $ownerId = $owner->id;
        $ownerName = $owner->name;

        $query = "INSERT INTO `lobby`(`id`, `ownerId`,`ownerName`, `amountPlayers`, `maxAmountPlayers`, `mode`, `map`)
         VALUES(" . "null" .  "," .
            $ownerId .  ", '" .
            $ownerName .  "'," .
            0 .  "," .
            $maxAmountPlayers .  ",'" .
            $mode .  "','" .
            $map .   " ')";
        $this->db->query($query);

        $query = 'SELECT `id` FROM `lobby` WHERE ownerId=' . $ownerId;
        $lobbyId = $this->db->query($query)->fetchObject()->id;
        $this->db->query('UPDATE `gamers` SET lobbyId=' . $lobbyId . ' WHERE userId=' . $ownerId);
        return $lobbyId;
    }

    public function startMatch($token, $lobbyId, $lobbyOwnerId, $lobbyAmountPlayers, $mode, $map)
    {
        $Time = time();
        $a = 0;
        $query = "INSERT INTO `matches`(`id`, `ownerId`, `amountPlayers`, `time`, `mode`, `map`, `status`, `timestemp`, `hash`)
        VALUES(" . "null" .  "," .
            $lobbyOwnerId .  "," .
            $lobbyAmountPlayers .  "," .
            $Time .  ", '" .
            $mode .  "','" .
            $map .  "','" .
            "open" .  "'," .
            $a .    "," .
            $a . " )";
        $this->db->query($query);

        $query = 'SELECT `id` FROM `matches` WHERE ownerId = ' . $lobbyOwnerId;
        $matchId = $this->db->query($query)->fetchObject()->id;
        $query = 'UPDATE `gamers` SET `lobbyId`=' . "null" . ',`matchId`= ' . $matchId . ' WHERE `lobbyId` =' . $lobbyId;
        //print_r($query);
        $matchId = $this->db->query($query);

        $query = 'DELETE FROM `lobby` WHERE `id` =' . $lobbyId;
        //print_r($query);
        $this->db->query($query);

        return true;
    }

    public function joinToLobby($lobbyId, $token)
    {
        $userId = $this->getUserByToken($token)->id;

        $query = 'UPDATE `gamers` SET `lobbyId`=' . $lobbyId . ' WHERE `userId` =' . $userId;
        $this->db->query($query);
        $query = 'UPDATE `lobby`   SET `amountPlayers` = `amountPlayers` +  1  WHERE `id` = ' . $lobbyId;
        $this->db->query($query);

        return true;
    }

    public function leaveLobby($lobbyId, $token)
    {
        $userId = $this->getUserByToken($token)->id;

        $query = 'UPDATE `gamers` SET `lobbyId`=' . "null" . ' WHERE `userId` =' . $userId;
        $this->db->query($query);
        $query = 'UPDATE `lobby`   SET `amountPlayers` = `amountPlayers` -  1  WHERE `id` = ' . $lobbyId;
        $this->db->query($query);

        return true;
    }

    public function getUsersInLobby($lobbyId, $token)
    {
        $stmt = $this->db->query('SELECT * FROM `gamers` ');
        $result = array();
        while ($row = $stmt->fetchObject()) {
            if ($row->lobbyId == $lobbyId)
                $result[] = $row;
        }
        return $result;
    }

    public function deleteLobby($token)
    {
        $ownerId = $this->getUserByToken($token)->id;

        $query = 'DELETE FROM `lobby` WHERE `ownerId` =' . $ownerId;
        $this->db->query($query);
        return true;
    }

    public function getAllLobby()
    {
        $query = 'SELECT lobby.id, lobby.ownerId, lobby.ownerName, lobby.amountPlayers, lobby.maxAmountPlayers, lobby.mode, lobby.map,
        
         GROUP_CONCAT(gamers.gamerName) AS players
         FROM (`lobby` LEFT JOIN `gamers` ON lobby.id = gamers.lobbyId)
         GROUP BY lobby.id';

        $query = $this->getArray($query);
        return $query;
    }

    public function getGamer($gamerId)
    {

        $query = 'SELECT * FROM `gamers` WHERE userId=' . $gamerId;
        return $this->db->query($query)->fetchObject();
    }


    /* public function updateScene($gamerId, $gamerMatchId, $x, $y, $weapon, $weaponRotation, $weaponFlipY, $weaponY, $weaponX, $bullets, $playerHit) {

        // обновляем координаты и оружие игрока
        $query = 'UPDATE `gamers` SET `X`='. $x . ',`Y`= '. $y . ',`weaponRotation`= '. $weaponRotation . ',`weapon`= '. $weapon .
         ',`weaponFlipY`= '. $weaponFlipY . ',`weaponX`='. $weaponX . ',`weaponY`= '. $weaponY .' WHERE `id` ='. $gamerId;
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
        }*/

    /*public function updateGamer($gamerId, $player, $statusInMatch)
    {
        // обновляем координаты и оружие игрока
        if ($statusInMatch) {
            $query = 'UPDATE `gamers` SET `X`=' . $player->x . ',`Y`= ' . $player->y . ',`statusInmatch`= 1' . ' WHERE `id` =' . $gamerId;
            $this->db->query($query);
        }
    }*/

    public function updateGamer($gamerId, $player, $statusInMatch)
    {
        switch ($statusInMatch) {
            case "alive": {
                    $query = 'UPDATE gamers SET X = ' . $player->x . ', Y = ' . $player->y . ' WHERE id =' . $gamerId;
                    $this->db->query($query);
                    break;
                }
            case "dead": {
                    $query = 'UPDATE gamers SET X = ' . '0' . ', Y= ' . '0' . ', statusInmatch= "respawn"' . ' WHERE id =' . $gamerId;
                    $this->db->query($query);
                    break;
                }
            case "respawn": {
                    $query = 'UPDATE gamers SET X = ' . $player->x . ',Y= ' . $player->y . ',statusInmatch= "alive"' . ' WHERE id =' . $gamerId;
                    $this->db->query($query);
                    break;
                }
        }
        /*if ($statusInMatch != "dead" || $statusInMatch !="respawn") {
            $query = 'SELECT statusInMatch FROM gamers WHERE id = ' . $gamerId;
            $state = $this->db->query($query);
            if ($state == "alive") {
                $query = 'UPDATE gamers SET X=' . $player->x . ',Y= ' . $player->y . ',statusInmatch= `alive`' . ' WHERE id =' . $gamerId;
                $this->db->query($query);
            }
        }*/
    }

    public function updateSceneHash($gamerMatchId)
    {
        $hash = md5(rand());
        $query = 'UPDATE `matches` SET `hash`= " ' . $hash . ' " WHERE `id`=' . $gamerMatchId;
        $this->db->query($query);
    }

    public function updateGamerWeapon($gamerId, $weapon)
    {
        $query =  'UPDATE `gamers` SET `weaponRotation`= ' . $weapon->rotation  . ',`weapon`= "' . $weapon->name .
            '",`weaponX`=' . $weapon->x . ',`weaponY`= ' . $weapon->y . ' WHERE `id` =' . $gamerId;
        $this->db->query($query);
    }

    /*public function updateBullets($gamerId, $gamerMatchId, $bullets){
            // удаляем массив старых пуль
            $query = 'DELETE FROM `bullets` WHERE `gamerId` ='.$gamerId;
            $this->db->query($query);
        

            // добавляем массив текущих пуль
            // forEach bullet.x bullet.y - цикл по всем пулям
            for($i = 0; $i<count($bullets); $i++)
            {$query = $query = "INSERT INTO `bullets`(`id`, `gamerId`, `matchId`, `x`, `y`, `rotation`) VALUES(" .
            "null" .  "," . $gamerId  .  "," .  $gamerMatchId . "," . $bullets[$i]->x . ",". $bullets[$i]->y . ",". $bullets[$i]->rotation . ")";
            $this->db->query($query);}
        }*/

    public function updateBullets($gamerId, $gamerMatchId, $bullets)
    {
        // добавляем массив текущих пуль
        // forEach bullet.x bullet.y - цикл по всем пулям
        for ($i = 0; $i < count($bullets); $i++) {
            if ($bullets[$i]->status == "fly") {
                $query = 'UPDATE `bullets` SET `x`= ' . $bullets[$i]->x . ' , `y`= ' . $bullets[$i]->y . ' , `rotation`= ' . $bullets[$i]->rotation . ' WHERE `uniqId`= ' . $bullets[$i]->uniqId;
                $this->db->query($query);
            }
            if ($bullets[$i]->status == "destroy") {
                $query = 'DELETE FROM `bullets` WHERE `uniqId` =' . $bullets[$i]->uniqId;
                $this->db->query($query);
            }
            if ($bullets[$i]->status == "new") {
                $query = "INSERT INTO `bullets`(`id`, `gamerId`, `matchId`, `x`, `y`, `rotation`, `uniqId`) VALUES(" .
                    "null" . "," . $gamerId .
                    "," . $gamerMatchId . "," . $bullets[$i]->x . "," . $bullets[$i]->y . "," . $bullets[$i]->rotation . "," . $bullets[$i]->uniqId . ")";
                $this->db->query($query);
            }
        }
    }


    public function killPlayer($playerHit, $player)
    {
        $query = 'UPDATE `gamers` SET `statusInMatch`=' . '"dead"' . ' WHERE `id`=' . $playerHit;
        //print_r($query);
        $this->db->query($query);
        //жертва
        $query = 'UPDATE `gamers` SET `deaths`= `deaths` + 1' . ' WHERE `id`=' . $playerHit;
        $this->db->query($query);
        $query = 'SELECT `kills` FROM `gamers` WHERE id = ' . $playerHit;
        $victimK = $this->db->query($query)->fetchObject()->kills;
        $query = 'SELECT `deaths` FROM `gamers` WHERE id = ' . $playerHit;
        $victimD = $this->db->query($query)->fetchObject()->deaths;
        $query = 'UPDATE `gamers` SET `killsDeaths`=' . $victimK / $victimD . ' WHERE `id`=' . $playerHit;
        $this->db->query($query);
        //убийца 
        $query = 'UPDATE `gamers` SET `kills`= `kills` + 1' . ' WHERE `id`=' . $player;
        $this->db->query($query);
        $query = 'SELECT `kills` FROM `gamers` WHERE id = ' . $player;
        $killerK =$this->db->query($query)->fetchObject()->kills;
        $query = 'SELECT `deaths` FROM `gamers` WHERE id = ' . $player;
        $killerD =$this->db->query($query)->fetchObject()->deaths;
        if ($killerD != 0) {           
            $query = 'UPDATE `gamers` SET `killsDeaths`=' . $killerK / $killerD . ' WHERE `id`=' . $player;
            $this->db->query($query);
        } else {
            $query = 'UPDATE `gamers` SET `killsDeaths`=' . $killerK . ' WHERE `id`=' . $player;
            $this->db->query($query);
        }
    }

    public function getScene($gamerMatchId, $sceneHash)
    {
        $query = 'SELECT * FROM `matches` WHERE id = ' . $gamerMatchId;
        $nehuy = $this->db->query($query)->fetchObject();
        if ($nehuy->status != "finish") {
            $newSceneHash = $nehuy->hash;
            if ($newSceneHash == $sceneHash) {
                $array = array(
                    "result" => 0,
                    "status" => "continue"
                );
                return $array;
            } else {
                // массив игроков
                $query = 'SELECT * FROM `gamers`WHERE matchId = ' . $gamerMatchId;
                $gamers = $this->getArray($query);
                //массив пуль
                $query = 'SELECT * FROM `bullets` WHERE matchId = ' . $gamerMatchId;
                $bullets = $this->getArray($query);
                $array = array(
                    "gamers" => $gamers,
                    "bullets" => $bullets,
                    "sceneHash" => $newSceneHash,
                    "status" => "continue"
                );
            }
        } else
            $array = array(
                "status" => "finish"
            );

        return $array;
    }

    /* public function getScene($gamerMatchId, $sceneHash)
    {
        $query = 'SELECT * FROM `matches` WHERE id = ' . $gamerMatchId;
        $nehuy = $this->db->query($query)->fetchObject();
        $newSceneHash = $nehuy->hash;
        if ($newSceneHash == $sceneHash) {
            $array = array(
                "result" => 0
            );
            return $array;
        } else {
            // массив игроков
            $query = 'SELECT * FROM `gamers`WHERE matchId = ' . $gamerMatchId;
            $gamers = $this->getArray($query);
            //массив пуль
            $query = 'SELECT * FROM `bullets` WHERE matchId = ' . $gamerMatchId;
            $bullets = $this->getArray($query);
            $array = array(
                "gamers" => $gamers,
                "bullets" => $bullets,
                "sceneHash" => $newSceneHash
            );
            return $array;
        }
    }*/

    /*public function leaveMatch($gamerId, $matchId)
    {
        $query = 'UPDATE `gamers` SET `statusInMatch`=' . `alive` . ' , `matchId`= ' . 'null' . ' WHERE `id` = ' . $gamerId;
        //print_r($query);
        $this->db->query($query);
        //$query = 'UPDATE `gamers` SET `matchId`=' . 'null' . ' WHERE `id` = '.$gamerId;
        //$this->db->query($query);
        return true;
    }*/

    public function leaveMatch($gamerId, $matchId)
    {
        $query = 'UPDATE `gamers` SET `statusInMatch`=' . `alive` . ' , `matchId`= ' . 'null' . ' WHERE `id` = ' . $gamerId;
        $this->db->query($query);

        $query = 'UPDATE `matches` SET `amountPlayers` = `amountPlayers` - 1 WHERE `id` = ' . $matchId;
        $this->db->query($query);

        $query = 'SELECT * FROM `matches` WHERE id = ' . $matchId;
        $match = $this->db->query($query)->fetchObject();

        if ($match->amountPlayers == 0)
            $query = 'DELETE FROM `matches` WHERE `id` =' . $matchId;
        $this->db->query($query);

        $query = 'UPDATE gamers SET 
                                    X = 0, 
                                    Y = 0, 
                                    matchId= ' . 'null' . 
                                    ', lobbyId= ' . 'null' .
                                    ',statusInMatch="alive", 
                                    deaths= ' . 0 .
                                    ',kills= ' . 0 .
                                    ' WHERE id= ' . $gamerId;
        $this->db->query($query);
        

        return true;
    }

    public function deleteMatch($token)
    {
        $ownerId = $this->getUserByToken($token)->id;

        $query = 'DELETE FROM `matches` WHERE `ownerId` =' . $ownerId;
        $this->db->query($query);
        return true;
    }

    public function checkEnd($gamerMatchId)
    {
        
        $query = 'SELECT * FROM `matches` WHERE id = ' . $gamerMatchId;
        $match = $this->db->query($query)->fetchObject();
        
        $time = time();
        
        switch ($match->mode) {
            case 'time': {
                    if (($time - $match->time) >= 90)
                        $query = 'UPDATE `matches` SET `status`=' . "finish" . ' WHERE `id` = ' . $gamerMatchId;
                    $this->db->query($query);
                    break;
                }
            case 'kills': {
                    
                    $query = 'SELECT * FROM `gamers` WHERE matchId = ' . $gamerMatchId;
                    $gamers = $this->getArray($query);
                    for ($i = 0; $i < count($gamers); $i++) {
                        if ($gamers[$i]->kills >= 10) {
                            $query = 'UPDATE `matches` SET `status`= "finish" WHERE `id` = ' . $gamerMatchId;
                            $this->db->query($query);
                        }
                    }
                    break;
                }
        }
    }

    public function getAllRecords($tableName) {
        $query = 'SELECT * FROM ' . $tableName;
        $temp = $this->getArray($query);
        return $temp;
    }
}
