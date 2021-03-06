<?php

namespace application\controller\action;

use application\controller\Redirect;
use application\model\User;

defined('INDEX') or die;

class Logout extends AbstractAction {

    private $user;

    function __construct(User $user) {
        $this->user = $user;
    }

    public function excute() {
        $this->user->logout();
        new Redirect();
    }

    public function setVars() {

    }

    public function getView() {
        return null;
    }

    public function getTitle() {
        return null;
    }

    public function requireLogin() {
        return false;
    }

}
