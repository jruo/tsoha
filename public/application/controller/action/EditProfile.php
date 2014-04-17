<?php

namespace application\controller\action;

use application\controller\Formatter;
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
            header('location:' . BASEURL);
            die;
        }

        $this->profile = new ProfileModel($this->database, $this->userID);
        $this->profileInfo = $this->profile->getProfileInfo();

        if (!$this->profile->isValid()) {
            header('location:' . BASEURL . '?message=Virheellinen käyttäjä');
            die;
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
            header('location:' . BASEURL . "?action=editprofile&id={$this->userID}&message=Iän täytyy olla positiivinen kokonaisluku");
            die;
        }


        if ($passwordOld == '' && $password1 == '' && $password2 == '') {
            // the user didn't want to change password
            header('location:' . BASEURL . "?action=profile&id={$this->userID}&info=Profiili tallennettu");
            die;
        }

        // the user wanted to change password
        if (!User::isCorrectPassword($this->database, $this->userID, $passwordOld)) {
            header('location:' . BASEURL . "?action=editprofile&id={$this->userID}&info=Profiili tallennettu&message=Vanha salasana on väärä");
            die;
        }

        if ($password1 !== $password2) {
            header('location:' . BASEURL . "?action=editprofile&id={$this->userID}&info=Profiili tallennettu&message=Salasanat eivät täsmää");
            die;
        }

        if (!Validator::isValidPassword($password1)) {
            header('location:' . BASEURL . "?action=editprofile&id={$this->userID}&info=Profiili tallennettu&message=Salasanan tulee olla yli 5 ja alle 500 merkkiä pitkä");
            die;
        }

        // ok, change password
        User::setPassword($this->database, $this->userID, $password1);

        header('location:' . BASEURL . "?action=profile&id={$this->userID}&info=Profiili tallennettu ja salasana vaihdettu");
        die;
    }

    public function setVars() {
        $profileInfo = $this->profileInfo->asArray();
        $this->renderer->addVar('userID', $this->userID);
        $this->renderer->addVar('email', Formatter::escapeText($profileInfo['email']));
        $this->renderer->addVar('realName', Formatter::escapeText($profileInfo['realName']));
        $this->renderer->addVar('gender', $profileInfo['gender']);
        $this->renderer->addVar('age', $profileInfo['age']);
    }

    public function getTitle() {
        return 'Muokkaa profiilia';
    }

    public function getView() {
        return 'editprofile.php';
    }

    public function requireLogin() {
        return true;
    }

}
