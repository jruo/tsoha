<?php

namespace application\controller\action;

use application\controller\Request;
use application\model\Database;
use application\model\MemberGroup;
use application\model\User;

defined('INDEX') or die;

class AdminEditMemberGroups extends AbstractAction {

    private $database;
    private $request;
    private $user;
    private $memberGroups;

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
        $groupID = $this->request->getGetData('groupid');

        if (!isset($option)) {
            $this->memberGroups = MemberGroup::getGroups($this->database);
            return;
        }
        switch ($option) {
            case 'delete':
                if ($groupID != 0) {
                    MemberGroup::removeGroup($this->database, $groupID);
                    header('location:' . BASEURL . '?action=admineditmembergroups&info=Ryhmä poistettu');
                } else {
                    header('location:' . BASEURL . '?action=admineditmembergroups&message=Oletusryhmää ei voi poistaa.');
                }
                break;
            case 'create':
                if (MemberGroup::addGroup($this->database, $value)) {
                    header('location:' . BASEURL . '?action=admineditmembergroups&info=Ryhmä luotu');
                } else {
                    header('location:' . BASEURL . '?action=admineditmembergroups&message=Ryhmän luonti epäonnistui');
                }
                break;
            default:
                header('location:' . BASEURL . '?action=admineditmembergroups&message=Virheellinen toiminto');
        }

        die;
    }

    public function setVars() {
        $this->renderer->addVar('memberGroups', $this->memberGroups);
    }

    public function getTitle() {
        return 'Hallitse jäsenryhmiä';
    }

    public function getView() {
        return 'admineditmembergroups.php';
    }

    public function requireLogin() {
        return true;
    }

}
