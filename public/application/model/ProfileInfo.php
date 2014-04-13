<?php

namespace application\model;

defined('INDEX') or die;

class ProfileInfo {

    private $database;
    private $userID;
    private $validUser;
    private $username;
    private $timeRegistered;
    private $postCount;
    private $email;
    private $realName;
    private $gender;
    private $age;

    function __construct(Database $database, $userID) {
        $this->database = $database;
        $this->userID = $userID;
        $this->validUser = $this->loadUserInfo();
    }

    /**
     * Loads the info
     * @return boolean
     */
    private function loadUserInfo() {
        $query = <<<SQL
        select      member.username, member.memberid, memberinfo.timeregistered,
                    memberinfo.email, memberinfo.realname, memberinfo.age,
                    memberinfo.gender, postcount.postcount
        from        member, memberinfo, (
                        select member.memberid, postcount.postcount
                        from member
                        left join (
                            select memberid, count(*) as postcount
                            from post
                            group by memberid
                        ) as postcount
                        on member.memberid=postcount.memberid
                        where member.memberid=?
                    ) as postcount
        where       member.memberid=?
            and     member.memberid=memberinfo.memberid
            and     member.memberid=postcount.memberid;
SQL;

        $params = array($this->userID, $this->userID);
        $results = $this->database->query($query, $params);

        if (count($results) < 1) {
            return false;
        }
        $row = $results[0];

        $this->username = $row['username'];
        $this->timeRegistered = $row['timeregistered'];
        $this->postCount = $row['postcount'];
        $this->email = $row['email'];
        $this->realName = $row['realname'];
        $this->gender = $row['gender'];
        $this->age = $row['age'];

        return true;
    }

    /**
     * Sets the email
     * @param string $email
     */
    public function setEmail($email) {
        $query = 'update memberinfo set email=? where memberid=?;';
        $params = array($email, $this->userID);
        $this->database->query($query, $params);
        $this->email = $email;
    }

    /**
     * Sets the real name
     * @param string $realName
     */
    public function setRealName($realName) {
        $query = 'update memberinfo set realname=? where memberid=?;';
        $params = array($realName, $this->userID);
        $this->database->query($query, $params);
    }

    /**
     * Sets the age
     * @param string $age
     */
    public function setAge($age) {
        if ($age == '') {
            $age = null;
        }
        $query = 'update memberinfo set age=? where memberid=?;';
        $params = array($age, $this->userID);
        $this->database->query($query, $params);
    }

    /**
     * Sets the gender
     * @param string $gender
     */
    public function setGender($gender) {
        $query = 'update memberinfo set gender=? where memberid=?;';
        $params = array($gender, $this->userID);
        $this->database->query($query, $params);
    }

    public function getUsername() {
        return $this->username;
    }

    public function getTimeRegistered() {
        return $this->timeRegistered;
    }

    public function getPostCount() {
        return $this->postCount;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRealName() {
        return $this->realName;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getAge() {
        return $this->age;
    }

    public function isValidUser() {
        return $this->validUser;
    }

}
