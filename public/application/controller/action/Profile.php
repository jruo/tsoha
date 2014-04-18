<?php

namespace application\controller\action;

use application\controller\Formatter;
use application\controller\Redirect;
use application\controller\Request;
use application\model\Database;
use application\model\Profile as ProfileModel;
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

        $profile = new ProfileModel($this->database, $this->userID);
        $this->profileInfo = $profile->getProfileInfo();

        if (!$profile->isValid()) {
            new Redirect(array('message' => 'Virheellinen käyttäjä'));
        }
    }

    public function setVars() {
        switch ($this->profileInfo->getGender()) {
            case '1':
                $gender = 'Mies';
                break;
            case '0':
                $gender = 'Nainen';
                break;
            default:
                $gender = null;
                break;
        }
        $this->renderer->addVar('timeRegistered', Formatter::formatTime($this->profileInfo->getTimeRegistered()));
        $this->renderer->addVar('postCount', $this->profileInfo->getPostCount());
        $this->renderer->addVar('email', Formatter::escapeText($this->profileInfo->getEmail()));
        $this->renderer->addVar('realName', Formatter::escapeText($this->profileInfo->getRealName()));
        $this->renderer->addVar('gender', $gender);
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
