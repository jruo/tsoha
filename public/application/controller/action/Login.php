<?php

namespace application\controller\action;

use application\controller\Request;
use application\model\User;
use application\view\LoginView;

defined('INDEX') or die;

class Login extends AbstractAction {

    private $request;
    private $user;

    function __construct(Request $request, User $user) {
        $this->request = $request;
        $this->user = $user;
    }

    public function excute() {
        if ($this->user->isLoggedIn()) {
            header('location:?'); // already logged in, return to home page
            die;
        }

        $username = $this->request->getPostData('username');
        $password = $this->request->getPostData('password');

        if (!isset($username, $password)) {
            return; // credentials were not sent, do nothing (just display the form)
        }

        if ($this->user->login($username, $password)) {
            // login succesful, redirect to home page
            header('location:?');
            die;
        } else {
            // login failed, redirect to login form with an error
            header('location:?action=login&error=1');
            die;
        }
    }

    public function getView() {
        $view = new LoginView();
        $view->displayError($this->request->getGetData('error') == 1);
        return $view;
    }

    public function requireLogin() {
        return false;
    }

}
