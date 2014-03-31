<?php

namespace application\model;

defined('INDEX') or die;

class ProfileInfo {

    private $database;
    private $userID;
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
        $this->loadUserInfo();
    }

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
        $row = $results[0];

        $this->username = $row['username'];
        $this->timeRegistered = $row['timeregistered'];
        $this->postCount = $row['postcount'];
        $this->email = $row['email'];
        $this->realName = $row['realname'];
        $this->gender = $row['gender'];
        $this->age = $row['age'];
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

}
