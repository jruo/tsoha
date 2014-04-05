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
        $min = strlen(str_replace("\n", '', str_replace(' ', '', $post))) > 5;
        $max = strlen($post) <= 10000;
        return $min && $max;
    }

    /**
     * Checks if the given title is valid
     * @param string $title
     * @return boolean
     */
    public static function isValidTitle($title) {
        $min = strlen(str_replace("\n", '', str_replace(' ', '', $title))) > 5;
        $max = strlen($title) <= 100;
        return $min && $max;
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
