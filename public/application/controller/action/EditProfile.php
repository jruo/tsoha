<?php

namespace application\controller\action;

use application\controller\Formatter;
use application\controller\Redirect;
use application\controller\Request;
use application\controller\Validator;
use application\model\Database;
use application\model\Profile as ProfileModel;
use application\model\User;

defined('INDEX') or die;

class EditProfile extends AbstractAction {

    private $database;
    private $request;
    private $user;
    private $userID;
    private $profile;
    private $profileInfo;

    function __construct(Database $database, Request $request, User $user) {
        $this->database = $database;
        $this->request = $request;
        $this->user = $user;
    }

    public function excute() {
        if ($this->user->getUserID() == $this->request->getGetData('id') || $this->user->isAdmin()) {
            // allow editing only if it's the user's own profile or the user is an admin
            $this->userID = $this->request->getGetData('id');
        } else {
            new Redirect();
        }

        $this->profile = new ProfileModel($this->database, $this->userID);
        $this->profileInfo = $this->profile->getProfileInfo();

        if (!$this->profile->isValid()) {
            new Redirect(array('message' => 'Virheellinen käyttäjä'));
        }

        $email = $this->request->getPostData('email');
        $realName = $this->request->getPostData('realName');
        $gender = $this->request->getPostData('gender');
        $age = $this->request->getPostData('age');
        $passwordOld = $this->request->getPostData('passwordOld');
        $password1 = $this->request->getPostData('password1');
        $password2 = $this->request->getPostData('password2');

        if (!isset($email, $realName, $gender, $age, $passwordOld, $password1, $password2)) {
            // nothing was posted
            return;
        }

        // the user wanted to change something

        if ($gender == 'null') {
            $gender = null;
        }
        $this->profile->setEmail($email);
        $this->profile->setRealName($realName);
        $this->profile->setGender($gender);
        if (is_numeric($age) && $age > 1 && $age <= 2147483647) {
            $this->profile->setAge($age);
        } else {
            new Redirect(array('action' => 'editprofile', 'id' => $this->userID, 'message' => 'Iän täytyy olla positiivinen kokonaisluku'));
        }


        if ($passwordOld == '' && $password1 == '' && $password2 == '') {
            // the user didn't want to change password
            new Redirect(array('action' => 'profile', 'id' => $this->userID, 'info' => 'Profiili tallennettu'));
        }

        // the user wanted to change password
        if (!User::isCorrectPassword($this->database, $this->userID, $passwordOld)) {
            new Redirect(array('action' => 'editprofile', 'id' => $this->userID, 'info' => 'Profiili tallennettu', 'message' => 'Vanha salasana on väärä'));
        }

        if ($password1 !== $password2) {
            new Redirect(array('action' => 'editprofile', 'id' => $this->userID, 'info' => 'Profiili tallennettu', 'message' => 'Salasanat eivät täsmää'));
        }

        if (!Validator::isValidPassword($password1)) {
            new Redirect(array('action' => 'editprofile', 'id' => $this->userID, 'info' => 'Profiili tallennettu', 'message' => 'Salasanan tulee olla yli 5 ja alle 500 merkkiä pitkä'));
        }

        // ok, change password
        User::setPassword($this->database, $this->userID, $password1);

        new Redirect(array('action' => 'profile', 'id' => $this->userID, 'info' => 'Profiili tallennettu ja salasana vaihdettu'));
    }

    public function setVars() {
        $this->renderer->addVar('userID', $this->userID);
        $this->renderer->addVar('email', Formatter::escapeText($this->profileInfo->getEmail()));
        $this->renderer->addVar('realName', Formatter::escapeText($this->profileInfo->getRealName()));
        $this->renderer->addVar('gender', $this->profileInfo->getGender());
        $this->renderer->addVar('age', $this->profileInfo->getAge());
    }

    public function getTitle() {
        return 'Muokkaa profiilia ' . $this->profileInfo->getUsername();
    }

    public function getView() {
        return 'editprofile.php';
    }

    public function requireLogin() {
        return true;
    }

}
