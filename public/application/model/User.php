<?php

namespace application\model;

defined('INDEX') or die;

/**
 * The user
 */
class User {

    private $database;
    private $loggedIn;

    function __construct(Database $database) {
        $this->database = $database;
        $this->loggedIn = $this->testLoginState();
    }

    /**
     * Checks if the user is logged in
     * @return boolean true or false
     */
    private function testLoginState() {
        if (!isset($_SESSION['username'], $_SESSION['userid'], $_SESSION['ip'], $_SESSION['admin'])) {
            return false;
        }
        if ($_SESSION['ip'] === $_SERVER['REMOTE_ADDR']) {
            return true;
        } else {
            $this->logout();
            return false;
        }
    }

    public function isLoggedIn() {
        return $this->loggedIn;
    }

    public function isAdmin() {
        return $this->loggedIn && $_SESSION['admin'] == 1;
    }

    public function getUserID() {
        return $this->loggedIn ? $_SESSION['userid'] : null;
    }

    public function getUsername() {
        return $this->loggedIn ? $_SESSION['username'] : null;
    }

    /**
     * Logs the user in
     * @param string $username Username
     * @param string $password Password
     * @param boolean $remember Keep logged in?
     * @return boolean true if succeeded, false otherwise
     */
    public function login($username, $password, $remember = false) {
        session_regenerate_id(true);

        $query = 'SELECT username, memberid, password, salt, admin FROM Member WHERE lower(username)=lower(?);';
        $params = array($username);
        $results = $this->database->query($query, $params);

        if (count($results) == 0) {
            return false;
        }

        $row = $results[0];
        $passwordHashFromDB = $row['password'];
        $saltFromDB = $row['salt'];
        $userID = $row['memberid'];
        $username = $row['username'];
        $admin = $row['admin'];

        $givenPassword = new Password($password);
        if ($givenPassword->matches($passwordHashFromDB, $saltFromDB)) {
            $this->setSessionValues($username, $userID, $admin, $remember);
            return true;
        }
        return false;
    }

    public function logout() {
        session_destroy();
    }

    /**
     * Creates a new user
     * @param Database $database
     * @param string $username
     * @param string $passwordString
     * @return boolean
     */
    public static function create(Database $database, $username, $passwordString) {
        // check that the username is not already in use
        $query = 'select username from member where lower(username)=lower(?);';
        $params = array($username);
        $results = $database->query($query, $params);
        if (count($results) != 0) {
            return false;
        }

        // generate hash and salt
        $password = new Password($passwordString);
        $generated = $password->generateHashAndSalt();
        $hash = $generated[0];
        $salt = $generated[1];

        // create the user
        $query = 'insert into member (username, password, salt) values (?, ?, ?) returning memberid;';
        $params = array($username, $hash, $salt);
        $results = $database->query($query, $params);

        // create the user's profile
        $userID = $results[0]['memberid'];
        $query = 'insert into memberinfo (memberid, timeregistered) values (?, ?);';
        $params = array($userID, time());
        $database->query($query, $params);

        // add the user to the default user group
        MemberGroup::addUserToGroup($database, 0, $userID);

        return true;
    }

    /**
     * Checks if the given password is
     * @param Database $database
     * @param int $userID
     * @param string $passwordString
     */
    public static function isCorrectPassword(Database $database, $userID, $passwordString) {
        $query = 'select password, salt from member where memberid=?;';
        $params = array($userID);
        $results = $database->query($query, $params);
        
        $passwordFromDB = $results[0]['password'];
        $saltFromDB = $results[0]['salt'];
        
        $password = new Password($passwordString);
        return $password->matches($passwordFromDB, $saltFromDB);
    }
    
    /**
     * Sets a new password for the given user
     * @param Database $database
     * @param int $userID
     * @param string $passwordString
     */
    public static function setPassword(Database $database, $userID, $passwordString) {
        $password = new Password($passwordString);
        $generated = $password->generateHashAndSalt();
        $hash = $generated[0];
        $salt = $generated[1];
        
        $query = 'update member set password=?, salt=? where memberid=?;';
        $params = array($hash, $salt, $userID);
        $database->query($query, $params);
    }

    /**
     * Sets the session values
     * @param string $username
     * @param string $userid
     * @param string $admin
     * @param boolean $remember
     */
    private function setSessionValues($username, $userid, $admin, $remember) {
        if ($remember) {
            session_set_cookie_params(60 * 60 * 24 * 14);
            session_regenerate_id(true);
        }
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $userid;
        $_SESSION['admin'] = $admin;
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
    }

}
