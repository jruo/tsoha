<?php

namespace application\controller\action;

use application\controller\Request;
use application\model\Database;
use application\model\User;

defined('INDEX') or die;

class NewTopic extends AbstractAction {

    private $database;
    private $request;
    private $user;

    function __construct(Database $database, Request $request, User $user) {
        $this->database = $database;
        $this->request = $request;
        $this->user = $user;
    }

    public function excute() {
        
    }

    public function setVars() {
        
    }

    public function getTitle() {
        return 'Aloita uusi viestiketju';
    }

    public function getView() {
        return 'newtopic.php';
    }

    public function requireLogin() {
        return true;
    }

}
