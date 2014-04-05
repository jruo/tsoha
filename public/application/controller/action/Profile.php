<?php

namespace application\controller\action;

use application\controller\Request;
use application\model\Database;
use application\model\ProfileInfo;
use application\model\User;

defined('INDEX') or die;

class Profile extends AbstractAction {

    private $database;
    private $request;
    private $user;
    private $userID;
    private $profileInfo;

    function __construct(Database $database, Request $request, User $user) {
        $this->database = $database;
        $this->request = $request;
        $this->user = $user;
    }

    public function excute() {
        $this->userID = $this->request->getGetData('id');
        if (!isset($this->userID)) {
            $this->userID = $this->user->getUserID();
        }

        $this->profileInfo = new ProfileInfo($this->database, $this->userID);

        if (!$this->profileInfo->isValidUser()) {
            header('location:' . BASEURL . '?message=Virheellinen käyttäjä');
            die;
        }
    }

    public function setVars() {
        $this->renderer->addVar('timeRegistered', date('j.n.Y k\l\o H:i', $this->profileInfo->getTimeRegistered()));
        $this->renderer->addVar('postCount', $this->profileInfo->getPostCount());
        $this->renderer->addVar('email', $this->profileInfo->getEmail());
        $this->renderer->addVar('realName', $this->profileInfo->getRealName());
        $this->renderer->addVar('gender', $this->profileInfo->getGender() == '1' ? 'Mies' : 'Nainen');
        $this->renderer->addVar('age', $this->profileInfo->getAge());
        $this->renderer->addVar('userID', $this->userID);
        $this->renderer->addVar('canEdit', $this->userID == $this->user->getUserID() || $this->user->isAdmin());
    }

    public function getView() {
        return 'profile.php';
    }

    public function getTitle() {
        return 'Käyttäjä ' . $this->profileInfo->getUsername();
    }

    public function requireLogin() {
        return true;
    }

}
