<?php

namespace application\controller\action;

defined('INDEX') or die;

class Search extends AbstractAction {

    private $database;
    private $request;

    public function excute() {
        
    }

    public function setVars() {
        
    }

    public function getTitle() {
        return 'Haku';
    }

    public function getView() {
        return 'search.php';
    }

    public function requireLogin() {
        return true;
    }

}
