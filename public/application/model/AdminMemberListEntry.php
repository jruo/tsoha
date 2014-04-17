<?php

namespace application\model;

defined('INDEX') or die;

class AdminMemberListEntry extends DatabaseObject {

    private $userID;
    private $username;

    public function asArray() {
        return array(
            'userID' => $this->userID,
            'username' => $this->username
        );
    }

    public function createFromDatabaseRow(array $array) {
        $this->userID = $array['memberid'];
        $this->username = $array['username'];
    }

}
