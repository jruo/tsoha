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
    private $profileInfo;

    function __construct(Database $database, Request $request, User $user) {
        $this->database = $database;
        $this->request = $request;
        $this->user = $user;
    }

    public function excute() {
        $userID = $this->request->getGetData('id');
        if (!isset($userID)) {
            $userID = $this->user->getUserID();
        }

        $this->profileInfo = new ProfileInfo($this->database, $userID);
    }

    public function setLocals() {
        $this->renderer->addLocal('username', $this->profileInfo->getUsername());
        $this->renderer->addLocal('timeRegistered', date('j.n.Y k\l\o H:i', $this->profileInfo->getTimeRegistered()));
        $this->renderer->addLocal('postCount', $this->profileInfo->getPostCount());
        $this->renderer->addLocal('email', $this->profileInfo->getEmail());
        $this->renderer->addLocal('realName', $this->profileInfo->getRealName());
        $this->renderer->addLocal('gender', $this->profileInfo->getGender() == '1' ? 'Mies' : 'Nainen');
        $this->renderer->addLocal('age', $this->profileInfo->getAge());
    }

    public function getView() {
        return 'profileView.php';
    }

    public function getTitle() {
        return 'Käyttäjä ' . $this->profileInfo->getUsername();
    }

    public function requireLogin() {
        return true;
    }

}
