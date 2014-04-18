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
        $profileInfo = $this->profileInfo->asArray();
        switch ($profileInfo['gender']) {
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
        $this->renderer->addVar('timeRegistered', Formatter::formatTime($profileInfo['timeRegistered']));
        $this->renderer->addVar('postCount', $profileInfo['postCount']);
        $this->renderer->addVar('email', Formatter::escapeText($profileInfo['email']));
        $this->renderer->addVar('realName', Formatter::escapeText($profileInfo['realName']));
        $this->renderer->addVar('gender', $gender);
        $this->renderer->addVar('age', $profileInfo['age']);
        $this->renderer->addVar('userID', $this->userID);
        $this->renderer->addVar('canEdit', $this->userID == $this->user->getUserID() || $this->user->isAdmin());
    }

    public function getView() {
        return 'profile.php';
    }

    public function getTitle() {
        $profileInfo = $this->profileInfo->asArray();
        return 'Käyttäjä ' . $profileInfo['username'];
    }

    public function requireLogin() {
        return true;
    }

}
