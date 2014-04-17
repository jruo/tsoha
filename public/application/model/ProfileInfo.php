<?php

namespace application\model;

defined('INDEX') or die;

class ProfileInfo extends DatabaseObject {

    private $username;
    private $timeRegistered;
    private $postCount;
    private $email;
    private $realName;
    private $gender;
    private $age;

    public function asArray() {
        return array(
            'username' => $this->username,
            'timeRegistered' => $this->timeRegistered,
            'postCount' => $this->postCount,
            'email' => $this->email,
            'realName' => $this->realName,
            'gender' => $this->gender,
            'age' => $this->age
        );
    }

    public function createFromDatabaseRow(array $array) {
        $this->username = $array['username'];
        $this->timeRegistered = $array['timeregistered'];
        $this->postCount = $array['postcount'];
        $this->email = $array['email'];
        $this->realName = $array['realname'];
        $this->gender = $array['gender'];
        $this->age = $array['age'];
    }

}
