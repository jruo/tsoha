<?php

namespace application\model;

defined('INDEX') or die;

class MemberGroupMember extends DatabaseObject {

    private $userID;
    private $username;

    public function asArray() {
        return array(
            'id' => $this->userID,
            'username' => $this->username
        );
    }

    public function createFromDatabaseRow(array $array) {
        $this->userID = $array['memberid'];
        $this->username = $array['username'];
    }

    public function getID() {
        return $this->userID;
    }

    public function getUsername() {
        return $this->username;
    }

}
