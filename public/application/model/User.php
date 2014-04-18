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

        if ($this->loggedIn && $this->isBanned()) {
            $this->logout();
            header('location:' . BASEURL . '?message=Tunnuksesi on suljettu');
            die;
        }
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

    public function isBanned() {
        $query = 'select disabled from member where memberid=?;';
        $params = array($this->getUserID());
        $results = $this->database->query($query, $params);
        return $results['0']['disabled'] == 1;
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
        MemberGroups::addUserToGroup($database, 0, $userID);

        return $database->querySucceeded();
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
     * @return boolean
     */
    public static function setPassword(Database $database, $userID, $passwordString) {
        $password = new Password($passwordString);
        $generated = $password->generateHashAndSalt();
        $hash = $generated[0];
        $salt = $generated[1];

        $query = 'update member set password=?, salt=? where memberid=?;';
        $params = array($hash, $salt, $userID);
        $database->query($query, $params);

        return $database->querySucceeded();
    }

    /**
     * Bans or unbans the given user
     * @param Database $database
     * @param int $userID
     * @param boolean $ban true=ban, false=unban
     * @return boolean
     */
    public static function setBan(Database $database, $userID, $ban) {
        $query = 'update member set disabled=? where memberid=?;';
        $params = array($ban ? 1 : 0, $userID);
        $database->query($query, $params);

        return $database->querySucceeded();
    }

    /**
     * Updates the admin state for the given user
     * @param Database $database
     * @param int $userID
     * @param boolean $admin
     * @return true
     */
    public static function setAdmin(Database $database, $userID, $admin) {
        $query = 'update member set admin=? where memberid=?;';
        $params = array($admin ? 1 : 0, $userID);
        $database->query($query, $params);

        return $database->querySucceeded();
    }

    /**
     * Permanently deletes the given user and everything referring to them
     * @param Database $database
     * @param int $userID
     */
    public static function delete(Database $database, $userID) {
        $query = 'delete from member where memberid=?;';
        $params = array($userID);
        $database->query($query, $params);
        $success = $database->querySucceeded();

        Topic::deleteEmptyTopics($database);

        return $success;
    }

    /**
     * Converts the given username to userID
     * @param Database $database
     * @param string $username
     * @return null|int
     */
    public static function usernameToID(Database $database, $username) {
        $query = 'select memberid from member where username=?;';
        $params = array($username);
        $results = $database->query($query, $params);
        if (count($results) == 0) {
            return null;
        } else {
            return $results[0]['memberid'];
        }
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
