<?php

namespace application\controller\action;

use application\controller\Redirect;
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
            // already logged in? no need to register then
            header('location:' . BASEURL);
        }

        $username = $this->request->getPostData('username');
        $password1 = $this->request->getPostData('password1');
        $password2 = $this->request->getPostData('password2');

        if (!isset($username, $password1, $password2)) {
            // nothing posted?
            return;
        }

        if ($password1 !== $password2) {
            new Redirect(array(
                'action' => 'register',
                'message' => 'Salasanat eivät täsmää'
                    ), array(
                'returnUsername' => $username)
            );
        }

        if (!Validator::isValidUsername($username)) {
            new Redirect(array(
                'action' => 'register',
                'message' => 'Käyttäjänimen tulee olla 4-20 merkkiä pitkä ja se saa sisältää kirjaimia, numeroita sekä merkkejä - _ . ja välilyöntejä'
                    ), array(
                'returnUsername' => $username)
            );
        }

        if (!Validator::isValidPassword($password1)) {
            new Redirect(array(
                'action' => 'register',
                'message' => 'Salasanan tulee olla yli 5 ja alle 500 merkkiä pitkä'
                    ), array(
                'returnUsername' => $username)
            );
        }

        if (User::create($this->database, $username, $password1)) {
            // success, also log the user in
            $this->user->login($username, $password1);
            new Redirect(array('info' => 'Rekisteröinti onnistui'));
        } else {
            // fail, the username is most likely already in use
            new Redirect(array(
                'action' => 'register',
                'message' => 'Käyttäjänimi on jo käytössä'
                    ), array(
                'returnUsername' => $username)
            );
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
