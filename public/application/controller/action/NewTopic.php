<?php

namespace application\controller\action;

use application\controller\Request;
use application\controller\Validator;
use application\model\Database;
use application\model\MemberGroup;
use application\model\Topic;
use application\model\User;

defined('INDEX') or die;

class NewTopic extends AbstractAction {

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
        // which groups the user has access to
        if ($this->user->isAdmin()) {
            $this->memberGroups = MemberGroup::getGroups($this->database);
        } else {
            $this->memberGroups = MemberGroup::getUsersGroups($this->database, $this->user->getUserID());
        }

        $topicTitle = $this->request->getPostData('title');
        $topicContent = $this->request->getPostData('content');

        if (!isset($topicTitle, $topicContent)) {
            // nothing was posted, do nothing
            return;
        }

        // user selected the topic to be public?
        $visibilityPublic = $this->request->getPostData('visibility-public');

        $topic = null;
        if ($visibilityPublic != '1') {
            // find out which membergroups the user selected
            $allGroups = MemberGroup::getGroups($this->database);
            $visibilityGroups = array();
            foreach ($allGroups as $group) {
                $visibility = $this->request->getPostData("visibility-{$group['id']}");
                if ($visibility == '1' && in_array($group, $this->memberGroups)) {
                    $visibilityGroups[] = $group;
                }
            }
            if (count($visibilityGroups) == 0) {
                // user didn't select anything
                $this->showError($topicTitle, $topicContent, 'Valitse näkyvyysmääreet viestiketjulle');
            } else {
                // create private topic visible to all selected $visibilityGroups
                $this->testPostValidity($topicTitle, $topicContent);
                $topic = Topic::create($this->database, $this->user, $topicTitle, $topicContent, 0);
                foreach ($visibilityGroups as $group) {
                    $topic->giveAccessToGroup($group['id']);
                }
            }
        } else {
            // create public topic;
            $visibilityPublic = 1;
            $this->testPostValidity($topicTitle, $topicContent);
            $topic = Topic::create($this->database, $this->user, $topicTitle, $topicContent, $visibilityPublic);
        }

        header('location:' . BASEURL . "?action=topic&id={$topic->getID()}");
        die;
    }

    private function testPostValidity($title, $content) {
        if (!Validator::isValidTitle($title)) {
            $this->showError($title, $content, 'Viestiketjun otsikon tulee olla vähintään 6 ja enintään 100 merkkiä pitkä');
        }
        if (!Validator::isValidPost($content)) {
            $this->showError($title, $content, 'Viestin tulee olla vähintään 6 ja enintään 10,000 merkkiä pitkä');
        }
    }

    private function showError($title, $content, $error) {
        $_SESSION['topicTitle'] = $title;
        $_SESSION['topicContent'] = $content;
        header('location:' . BASEURL . "?action=newtopic&message={$error}");
        die;
    }

    public function setVars() {
        $this->renderer->addVar('memberGroups', $this->memberGroups);
        if (isset($_SESSION['topicTitle'])) {
            $this->renderer->addVar('topicTitle', $_SESSION['topicTitle']);
            $this->renderer->addVar('topicContent', $_SESSION['topicContent']);
            $_SESSION['topicTitle'] = null;
            $_SESSION['topicContent'] = null;
        }
    }

    public function getTitle() {
        return 'Aloita uusi viestiketju';
    }

    public function getView() {
        return 'newtopic.php';
    }

    public function requireLogin() {
        return true;
    }

}
