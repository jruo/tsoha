<?php

namespace application\model;

defined('INDEX') or die;

class Password {

    private $password;

    public function __construct($password) {
        $this->password = $password;
    }

    /**
     * Checks if the password matches the given hash and salt
     * @param string $hash Password hash
     * @param string $salt Salt
     * @return boolean true or false
     */
    public function matches($hash, $salt) {
        $currentHash = $this->hash($salt);
        return $hash === $currentHash;
    }

    /**
     * Generates a new hash and salt for the password
     * @return array hash and its salt
     */
    public function generateHashAndSalt() {
        $salt = \base64_encode(\mcrypt_create_iv(40, \MCRYPT_DEV_URANDOM));
        $hash = $this->hash($salt);
        return array($hash, $salt);
    }

    /**
     * Hashes the password with the given salt
     * @param string $salt Salt
     * @return string hashed password
     */
    private function hash($salt) {
        return \hash('sha256', $this->password . $salt);
    }

}
