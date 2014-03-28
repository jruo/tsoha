<?php

namespace application\controller\action;

use application\model\User;

defined('INDEX') or die;

class Logout extends AbstractAction {

    private $user;

    function __construct(User $user) {
        $this->user = $user;
    }

    public function excute() {
        $this->user->logout();
        header('location:?');
        die;
    }

    public function getView() {
        return null; // will never get called
    }

    public function requireLogin() {
        return false;
    }

}
