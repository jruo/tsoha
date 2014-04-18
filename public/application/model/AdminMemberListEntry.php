<?php

namespace application\model;

defined('INDEX') or die;

class AdminMemberListEntry extends DatabaseObject {

    private $userID;
    private $username;
    private $admin;
    private $disabled;

    public function asArray() {
        return array(
            'userID' => $this->userID,
            'username' => $this->username,
            'admin' => $this->admin,
            'disabled' => $this->disabled
        );
    }

    public function createFromDatabaseRow(array $array) {
        $this->userID = $array['memberid'];
        $this->username = $array['username'];
        $this->admin = $array['admin'];
        $this->disabled = $array['disabled'];
    }

    public function getUserID() {
        return $this->userID;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getAdmin() {
        return $this->admin;
    }

    public function getDisabled() {
        return $this->disabled;
    }

}
