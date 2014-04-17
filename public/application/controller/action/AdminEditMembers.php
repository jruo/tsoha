<?php

namespace application\controller\action;

use application\controller\Request;
use application\model\AdminMemberList;
use application\model\Database;
use application\model\User;

defined('INDEX') or die;

class AdminEditMembers extends AbstractAction {

    private $database;
    private $request;
    private $user;
    private $memberList = array();

    function __construct(Database $database, Request $request, User $user) {
        $this->database = $database;
        $this->request = $request;
        $this->user = $user;
    }

    public function excute() {
        if (!$this->user->isAdmin()) {
            header('location:' . BASEURL);
            die;
        }

        $option = $this->request->getGetData('option');
        $userID = $this->request->getGetData('userid');

        if (!isset($option)) {
            $this->loadMemberList();
        } else {

        }
    }

    private function loadMemberList() {
        $listModel = new AdminMemberList($this->database);
        $memberList = $listModel->getList();
        foreach ($memberList as $member) {
            $this->memberList[] = $member->asArray();
        }
    }

    public function setVars() {

    }

    public function getTitle() {
        return 'Hallitse jäsenluetteloa';
    }

    public function getView() {
        return 'admineditmembers.php';
    }

    public function requireLogin() {
        return true;
    }

}
