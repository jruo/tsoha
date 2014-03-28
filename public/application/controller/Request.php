<?php

namespace application\controller;

defined('INDEX') or die;

/**
 * The user's request
 */
class Request {

    public function getGetData($var) {
        return filter_input(INPUT_GET, $var);
    }

    public function getPostData($var) {
        return filter_input(INPUT_POST, $var);
    }

    public function getAction() {
        return $this->getGetData('action');
    }

}
