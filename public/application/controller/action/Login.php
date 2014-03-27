<?php

namespace application\controller\action;

use application\controller\Request;
use application\model\User;

defined('INDEX') or die;

class Login extends AbstractAction {

    private $request;
    private $user;

    function __construct(Request $request, User $user) {
        $this->request = $request;
        $this->user = $user;
    }

    public function activate() {
        if ($this->user->isLoggedIn()) {
            header('location:?'); // already logged in, return to home
            die;
        }

        $username = $this->request->getPostData('username');
        $password = $this->request->getPostData('password');

        if (!isset($username, $password)) {
            return; // credentials were not sent, do nothing
        }

        if ($this->user->login($username, $password)) {
            // login succesful, redirect to home
            header('location:?');
            die;
        } else {
            // login failed, redirect to login page with error
            header('location:?action=login&error=1');
            die;
        }
    }

    public function getView() {

    }

}
