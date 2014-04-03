<?php

namespace application\controller\action;

use application\controller\Request;
use application\model\Database;
use application\model\ProfileInfo;
use application\model\User;

defined('INDEX') or die;

class EditProfile extends AbstractAction {

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
        if ($this->user->getUserID() == $this->request->getGetData('id') || $this->user->isAdmin()) {
            // allow editing only if it's the user's own profile or the user is an admin
            $this->userID = $this->request->getGetData('id');
        } else {
            header('location:' . BASEURL);
            die;
        }
        
        $this->profileInfo = new ProfileInfo($this->database, $this->userID);
    }

    public function setVars() {
        $this->renderer->addVar('userID', $this->userID);
        $this->renderer->addVar('email', $this->profileInfo->getEmail());
        $this->renderer->addVar('realName', $this->profileInfo->getRealName());
        $this->renderer->addVar('gender', $this->profileInfo->getGender());
        $this->renderer->addVar('age', $this->profileInfo->getAge());
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
