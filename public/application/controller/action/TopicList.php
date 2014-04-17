<?php

namespace application\controller\action;

use application\controller\Formatter;
use application\model\Database;
use application\model\TopicList as TopicListModel;
use application\model\User;

defined('INDEX') or die;

class TopicList extends AbstractAction {

    private $user;
    private $topicLoader;
    private $publicTopics;
    private $privateTopics;

    function __construct(Database $database, User $user) {
        $this->user = $user;
        $this->topicLoader = new TopicListModel($database, $user);
    }

    public function excute() {
        $this->addPublicTopics();
        if ($this->user->isLoggedIn()) {
            $this->addPrivateTopics();
        }
    }

    public function setVars() {
        $this->renderer->addVar('publicTopics', $this->publicTopics);
        $this->renderer->addVar('privateTopics', $this->privateTopics);
    }

    public function getView() {
        return 'topiclist.php';
    }

    public function getTitle() {
        return 'Keskustelufoorumi';
    }

    public function requireLogin() {
        return false;
    }

    private function addPublicTopics() {
        $topics = $this->topicLoader->getPublicTopics();
        $this->publicTopics = $this->formatTopics($topics);
    }

    private function addPrivateTopics() {
        $topics = $this->topicLoader->getPrivateTopics();
        $this->privateTopics = $this->formatTopics($topics);
    }

    private function formatTopics($topics) {
        $array = array();
        foreach ($topics as $topic) {
            $topicArray = $topic->asArray();
            $topicArray['title'] = Formatter::escapeText($topicArray['title']);
            $topicArray['time'] = Formatter::formatTime($topicArray['time']);
            $array[] = $topicArray;
        }
        return $array;
    }

}
