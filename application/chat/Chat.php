<?php
class Chat {
    function __construct($db) {
        $this->db = $db;
    }

    function sendMessage($userId, $userName, $message) {
        $this->db->sendMessage($userId, $userName, $message);
        $hash = md5(rand());
        $this->db->setChatHash($hash);
        return array (
            "hash" => $hash
        );
    }

    function getMessages($hash){
        $dbHash = $this->db->getChatHash()->chat_hash;
        if ($dbHash !== $hash) {
            return array( 
                'messages' => $this->db->getMessages(),
                'hash' => $dbHash
            );
        }
    }
}
