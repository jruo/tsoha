<?php

namespace application\controller\action;

use application\controller\Redirect;
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
            new Redirect();
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
                    new Redirect(array('action' => 'admineditmembers', 'info' => 'Ylläpitäjyys muutettu'));
                    break;
                case 'setban':
                    User::setBan($this->database, $userID, $mode);
                    new Redirect(array('action' => 'admineditmembers', 'info' => 'Porttikielto muutettu'));
                    break;
                case 'delete':
                    User::delete($this->database, $userID);
                    new Redirect(array('action' => 'admineditmembers', 'info' => 'Jäsen poistettu'));
                    break;
                default:
                    new Redirect(array('action' => 'admineditmembers', 'message' => 'Virheellinen toiminto'));
            }
        } else {
            new Redirect(array('action' => 'admineditmembers', 'message' => 'Et voi suorittaa tätä toimintoa itsellesi'));
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
