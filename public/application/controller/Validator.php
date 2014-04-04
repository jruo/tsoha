<?php

namespace application\controller;

defined('INDEX') or die;

class Validator {

    /**
     * Checks if the given post is valid
     * @param string $post
     * @return boolean
     */
    public static function isValidPost($post) {
        $post = str_replace(' ', '', $post);
        $post = str_replace("\n", '', $post);
        return strlen($post) > 5 && strlen($post) < 5000;
    }

    /**
     * Checks if the given username is valid
     * @param string $username
     * @return boolean
     */
    public static function isValidUsername($username) {
        return preg_match('/^[a-öA-Ö0-9 \-_\.]{4,20}$/', $username);
    }

    /**
     * Checks if the given password is valid
     * @param string $password
     * @return boolean
     */
    public static function isValidPassword($password) {
        return strlen($password) > 5 && strlen($password) < 500;
    }

}
