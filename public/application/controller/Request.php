<?php

namespace application\controller;

defined('INDEX') or die;

/**
 * The user's request
 */
class Request {

    /**
     * Get HTTP GET data
     * @param string $var
     * @return string
     */
    public function getGetData($var) {
        return filter_input(INPUT_GET, $var);
    }

    /**
     * Get HTTP POST data
     * @param string $var
     * @return string
     */
    public function getPostData($var) {
        return filter_input(INPUT_POST, $var);
    }

    /**
     * Get the requested action
     * @return string
     */
    public function getAction() {
        return $this->getGetData('action');
    }

}
