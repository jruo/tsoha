<?php

namespace application\controller\action;

use application\controller\Request;
use application\model\Database;

class Topic extends AbstractAction {

    private $database;
    private $request;

    function __construct(Database $database, Request $request) {
        $this->database = $database;
        $this->request = $request;
    }

    public function excute() {
        
    }

    public function setVars() {
        
    }

    public function getTitle() {
        
    }

    public function getView() {
        return 'topic.php';
    }

    public function requireLogin() {
        return false;
    }

}
