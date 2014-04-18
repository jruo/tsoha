<?php

namespace application\controller;

defined('INDEX') or die;

class Redirect {

    function __construct($redirect = null, array $sessionVars = null) {
        $this->setSessionVars($sessionVars);
        if (is_array($redirect) || $redirect == null) {
            $URL = $this->constructGetRequest($redirect);
        } else {
            $URL = $redirect;
        }

        header('location:' . $URL);
        die;
    }

    private function setSessionVars(array $sessionVars = null) {
        if ($sessionVars == null) {
            return;
        }
        foreach ($sessionVars as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    private function constructGetRequest(array $GETVars = null) {
        if ($GETVars == null || empty($GETVars)) {
            return BASEURL;
        }

        $URL = BASEURL . '?';
        foreach ($GETVars as $key => $value) {
            $URL .= $key . '=' . $value;
            if ($value != end($GETVars)) {
                $URL .= '&';
            }
        }

        return $URL;
    }

}
