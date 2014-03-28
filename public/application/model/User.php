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
        return $_SESSION['ip'] === $_SERVER['REMOTE_ADDR'];
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
     * @return boolean true if succeeded, false otherwise
     */
    public function login($username, $password) {
        session_regenerate_id(true);

        $query = 'SELECT memberid, password, salt, admin FROM Member WHERE username=?;';
        $params = array($username);
        $results = $this->database->query($query, $params);

        if (count($results) == 0) {
            echo "zero rows";
            return false;
        }

        $row = $results[0];
        $passwordHashFromDB = $row['password'];
        $saltFromDB = $row['salt'];
        $userID = $row['memberid'];
        $admin = $row['admin'];

        $givenPassword = new Password($password);
        if ($givenPassword->matches($passwordHashFromDB, $saltFromDB)) {
            $this->setSessionValues($username, $userID, $admin);
            return true;
        }
        return false;
    }

    private function setSessionValues($username, $userid, $admin) {
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $userid;
        $_SESSION['admin'] = $admin;
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
    }

    public function logout() {
        session_destroy();
    }

}
