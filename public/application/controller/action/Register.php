<?php

namespace application\controller\action;

use application\controller\Request;
use application\controller\Validator;
use application\model\Database;
use application\model\User;

defined('INDEX') or die;

class Register extends AbstractAction {

    private $database;
    private $request;
    private $user;

    function __construct(Database $database, Request $request, User $user) {
        $this->database = $database;
        $this->request = $request;
        $this->user = $user;
    }

    public function excute() {
        if ($this->user->isLoggedIn()) {
            header('location:' . BASEURL);
        }

        $username = $this->request->getPostData('username');
        $password1 = $this->request->getPostData('password1');
        $password2 = $this->request->getPostData('password2');

        if (!isset($username, $password1, $password2)) {
            return;
        }

        if ($password1 !== $password2) {
            $_SESSION['returnUsername'] = $username;
            header('location:' . BASEURL . '?action=register&message=Salasanat eivät täsmää');
            die;
        }
        
        if (!Validator::isValidUsername($username)) {
            $_SESSION['returnUsername'] = $username;
            header('location:' . BASEURL . '?action=register&message=Käyttäjänimen tulee olla 4-20 merkkiä pitkä ja se saa sisältää kirjaimia, numeroita sekä merkkejä - _ . ja välilyöntejä');
            die;
        }
        
        if (!Validator::isValidPassword($password1)) {
            $_SESSION['returnUsername'] = $username;
            header('location:' . BASEURL . '?action=register&message=Salasanan tulee olla yli 5 ja alle 500 merkkiä pitkä');
            die;
        }
        
        if (User::create($this->database, $username, $password1)) {
            // success, also log the user in
            $this->user->login($username, $password1);
            header('location:' . BASEURL . '?info=Rekisteröinti onnistui');
            die;
        } else {
            // fail, the username is most likely already in use
            $_SESSION['returnUsername'] = $username;
            header('location:' . BASEURL . '?action=register&message=Käyttäjänimi on jo käytössä');
            die;
        }
    }

    public function setVars() {
        if (isset($_SESSION['returnUsername'])) {
            $this->renderer->addVar('returnUsername', $_SESSION['returnUsername']);
            $_SESSION['returnUsername'] = null;
        }
    }

    public function getTitle() {
        return 'Rekisteröidy keskustelufoorumille';
    }

    public function getView() {
        return 'register.php';
    }

    public function requireLogin() {
        return false;
    }

}
