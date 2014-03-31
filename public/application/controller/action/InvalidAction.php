<?php

namespace application\controller\action;

defined('INDEX') or die;

class InvalidAction extends AbstractAction {

    public function excute() {
        
    }

    public function setVars() {
        
    }

    public function getView() {
        return 'pageNotFound.php';
    }

    public function getTitle() {
        return '404 - Sivua ei löydy';
    }

    public function requireLogin() {
        return false;
    }

}
