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

    public function excute() {
        if ($this->user->isLoggedIn()) {
            header('location:' . BASEURL); // already logged in, return to home page
            die;
        }

        $username = $this->request->getPostData('username');
        $password = $this->request->getPostData('password');

        if (!isset($username, $password)) {
            return; // credentials were not sent, do nothing (just display the form)
        }

        $baseURL = BASEURL;
        if ($this->user->login($username, $password)) {
            // login succesful, redirect to home page
            header("location:{$baseURL}");
            die;
        } else {
            // login failed, redirect to login form with an error
            header("location:{$baseURL}?action=login&error=1");
            die;
        }
    }
    
    public function setVars() {
        $this->renderer->addVar('error', $this->request->getGetData('error') == '1');
        $this->renderer->addVar('message', $this->request->getGetData('message'));
    }

    public function getView() {
        return 'login.php';
    }

    public function getTitle() {
        return 'Kirjaudu sisään';
    }
    
    public function requireLogin() {
        return false;
    }
}
