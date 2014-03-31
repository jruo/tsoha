<?php

namespace application\controller\action;

use application\model\User;

defined('INDEX') or die;

class AdminPanel extends AbstractAction {

    private $user;

    function __construct(User $user) {
        $this->user = $user;
    }

    public function excute() {
        if (!$this->user->isAdmin()) {
            header('location:' . BASEURL);
            die;
        }
    }

    public function setVars() {
        
    }

    public function getTitle() {
        return 'Ylläpito';
    }

    public function getView() {
        return 'adminpanel.php';
    }

    public function requireLogin() {
        return true;
    }

}
