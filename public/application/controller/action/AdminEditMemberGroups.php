<?php

namespace application\controller\action;

use application\controller\Redirect;
use application\controller\Request;
use application\controller\Validator;
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
            new Redirect();
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
                    new Redirect(array('action' => 'admineditmembergroups', 'info' => 'Ryhmä poistettu'));
                } else {
                    new Redirect(array('action' => 'admineditmembergroups', 'message' => 'Oletusryhmää ei voi poistaa'));
                }
                break;
            case 'create':
                if (MemberGroup::addGroup($this->database, $value)) {
                    new Redirect(array('action' => 'admineditmembergroups', 'info' => 'Ryhmä luotu'));
                } else {
                    new Redirect(array('action' => 'admineditmembergroups', 'message' => 'Ryhmän luonti epäonnistui'));
                }
                break;
            case 'rename':
                if ($groupID != 0) {
                    if (Validator::isValidMemberGroupName($value)) {
                        if (MemberGroup::renameGroup($this->database, $groupID, $value)) {
                            new Redirect(array('action' => 'admineditmembergroups', 'info' => 'Ryhmä uudelleennimetty'));
                        } else {
                            new Redirect(array('action' => 'admineditmembergroups', 'message' => 'Uudelleennimeäminen ei onnistunut'));
                        }
                    } else {
                        new Redirect(array('action' => 'admineditmembergroups', 'message' => 'Nimen on oltava vähintäään 5 ja enintään 100 merkkiä pitkä ja saa sisältää merkkejä . - _ sekä välilyöntejä.'));
                    }
                } else {
                    new Redirect(array('action' => 'admineditmembergroups', 'message' => 'Oletusryhmää ei voi muokata'));
                }
                break;
            default:
                new Redirect(array('action' => 'admineditmembergroups', 'message' => 'Virheellinen toiminto'));
        }
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
