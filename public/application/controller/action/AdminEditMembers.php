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
        $value = $this->request->getGetData('value');
        $userID = $this->request->getGetData('userid');

        if (!isset($option)) {
            $this->loadMemberList();
            return;
        }

        $mode = $value == '1' ? true : false;

        if ($userID != $this->user->getUserID()) {
            switch ($option) {
                case 'setadmin':
                    User::setAdmin($this->database, $userID, $mode);
                    header('location:' . BASEURL . '?action=admineditmembers&info=Ylläpitäjyys muutettu');
                    break;
                case 'setban':
                    User::setBan($this->database, $userID, $mode);
                    header('location:' . BASEURL . '?action=admineditmembers&info=Porttikielto muutettu');
                    break;
                case 'delete':
                    User::delete($this->database, $userID);
                    header('location:' . BASEURL . '?action=admineditmembers&info=Jäsen poistettu');
                    break;
                default:
                    header('location:' . BASEURL . '?action=admineditmembers&message=Virheellinen toiminto');
            }
        } else {
            header('location:' . BASEURL . '?action=admineditmembers&message=Et voi suorittaa tätä toimintoa itsellesi');
        }

        die;
    }

    private function loadMemberList() {
        $listModel = new AdminMemberList($this->database);
        $memberList = $listModel->getList();
        foreach ($memberList as $member) {
            $this->memberList[] = $member->asArray();
        }
    }

    public function setVars() {
        $this->renderer->addVar('memberList', $this->memberList);
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
