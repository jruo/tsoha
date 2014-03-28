<?php

namespace application\controller\action;

use application\view\PageNotFound;

defined('INDEX') or die;

class InvalidAction extends AbstractAction {

    public function excute() {
        
    }

    public function getView() {
        return new PageNotFound();
    }

    public function requireLogin() {
        return false;
    }

}
