<?php

namespace application\controller\action;

use application\controller\Formatter;
use application\model\Database;
use application\model\TopicListLoader;
use application\model\User;

defined('INDEX') or die;

class TopicList extends AbstractAction {

    private $user;
    private $topicLoader;
    private $publicTopics;
    private $privateTopics;

    function __construct(Database $database, User $user) {
        $this->user = $user;
        $this->topicLoader = new TopicListLoader($database, $user);
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
        $this->publicTopics = $this->parseTopics($topics);
    }

    private function addPrivateTopics() {
        $topics = $this->topicLoader->getPrivateTopics();
        $this->privateTopics = $this->parseTopics($topics);
    }

    private function parseTopics($topics) {
        $array = array();
        foreach ($topics as $topic) {
            $title = Formatter::escapeText($topic->getTitle());
            $topicID = $topic->getTopicID();
            $postCount = $topic->getPostCount();
            $user = $topic->getLastPostUsername();
            $userID = $topic->getLastPostUserID();
            $time = date('j.n.Y k\l\o H:i', $topic->getLastPostTime());
            $newPosts = $topic->getNewPosts();
            $array[] = array('title' => $title, 'topicID' => $topicID,
                'postCount' => $postCount, 'username' => $user,
                'userID' => $userID, 'time' =>$time, 'newPosts' => $newPosts);
        }
        return $array;
    }

}
