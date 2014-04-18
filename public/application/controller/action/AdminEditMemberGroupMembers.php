<?php

namespace application\controller\action;

use application\controller\Redirect;
use application\controller\Request;
use application\model\Database;
use application\model\MemberGroups;
use application\model\User;

defined('INDEX') or die;

class AdminEditMemberGroupMembers extends AbstractAction {

    private $database;
    private $request;
    private $user;
    private $groupID;
    private $members;

    function __construct(Database $database, Request $request, User $user) {
        $this->database = $database;
        $this->request = $request;
        $this->user = $user;
    }

    public function excute() {
        if (!$this->user->isAdmin()) {
            new Redirect();
        }

        $this->groupID = $this->request->getGetData('id');

        if ($this->groupID == 0) {
            new Redirect(array('action' => 'admineditmembergroups', 'message' => 'Oletusryhmää ei voi muokata'));
        }

        $members = MemberGroups::getGroupUsers($this->database, $this->groupID);
        foreach ($members as $member) {
            $this->members[] = $member->asArray();
        }

        $option = $this->request->getGetData('option');
        $value = $this->request->getGetData('value');

        if (!isset($option)) {
            return;
        }
        switch ($option) {
            case 'delete':
                if (MemberGroups::removeUserFromGroup($this->database, $this->groupID, $value)) {
                    new Redirect(array('action' => 'admineditmembergroupmembers', 'id' => $this->groupID, 'info' => 'Jäsen poistettu ryhmästä'));
                } else {
                    new Redirect(array('action' => 'admineditmembergroupmembers', 'id' => $this->groupID, 'message' => 'Jäsenen poisto epäonnistui'));
                }
                break;
            case 'add':
                $userID = User::usernameToID($this->database, $value);
                if ($userID != null) {
                    if (MemberGroups::addUserToGroup($this->database, $this->groupID, $userID)) {
                        new Redirect(array('action' => 'admineditmembergroupmembers', 'id' => $this->groupID, 'info' => 'Jäsen lisätty ryhmään'));
                    } else {
                        new Redirect(array('action' => 'admineditmembergroupmembers', 'id' => $this->groupID, 'message' => 'Jäsenen lisäys epäonnistui'));
                    }
                } else {
                    new Redirect(array('action' => 'admineditmembergroupmembers', 'id' => $this->groupID, 'message' => 'Jäsentä ' . $value . ' ei ole olemassa'));
                }
                break;
            default:
                new Redirect(array('action' => 'admineditmembergroupmembers', 'id' => $this->groupID, 'message' => 'Virheellinen toiminto'));
        }
    }

    public function setVars() {
        // no need to escape, only alphanumeric usernames
        $this->renderer->addVar('members', $this->members);
        $this->renderer->addVar('groupID', $this->groupID);
    }

    public function getTitle() {
        return 'Muokkaa jäsenryhmää';
    }

    public function getView() {
        return 'admineditmembergroupmembers.php';
    }

    public function requireLogin() {
        return true;
    }

}
