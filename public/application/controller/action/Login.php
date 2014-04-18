<?php

namespace application\controller\action;

use application\controller\Redirect;
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
            new Redirect(); // already logged in, return to home page
        }

        $username = $this->request->getPostData('username');
        $password = $this->request->getPostData('password');
        $remember = $this->request->getPostData('remember');

        if (!isset($username, $password)) {
            return; // credentials were not sent, do nothing (just display the form)
        }

        $loginStatus = $this->user->login($username, $password, $remember == 'true');
        if ($loginStatus == 1) {
            // login succesful, redirect to home page
            new Redirect(null);
        } elseif ($loginStatus == -1) {
            // user is banned, display error
            new Redirect(array('message' => 'Tunnuksesi on suljettu'));
        } else {
            // login failed, redirect to login form with an error
            new Redirect(array('action' => 'login', 'message' => 'Väärä käyttäjänimi tai salasana'));
        }
    }

    public function setVars() {

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
