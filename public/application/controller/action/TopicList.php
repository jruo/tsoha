<?php

namespace application\controller\action;

use application\model\Database;
use application\model\TopicLoader;
use application\model\User;
use application\view\TopicListView;

defined('INDEX') or die;

class TopicList extends AbstractAction {

    private $view;
    private $user;
    private $topicLoader;

    function __construct(Database $database, User $user) {
        $this->user = $user;
        $this->topicLoader = new TopicLoader($database, $user);
    }

    public function excute() {
        $this->view = new TopicListView();
        $this->addPublicTopics();
        if ($this->user->isLoggedIn()) {
            $this->addPrivateTopics();
            $this->addPrivateMemberGroupTopics();
        }
    }

    private function addPublicTopics() {
        $topics = $this->topicLoader->getPublicTopics();
        $this->view->addTopicGroup(TopicListView::PUBLIC_GROUP);
        $this->addTopics($topics, TopicListView::PUBLIC_GROUP);
    }

    private function addPrivateTopics() {
        $topics = $this->topicLoader->getPrivateTopics();
        $this->view->addTopicGroup(TopicListView::PRIVATE_GROUP);
        $this->addTopics($topics, TopicListView::PRIVATE_GROUP);
    }

    private function addTopics($topics, $topicGroup) {
        foreach ($topics as $topic) {
            $title = $topic->getTitle();
            $topicID = $topic->getTopicID();
            $postCount = $topic->getPostCount();
            $user = $topic->getLastPostUsername();
            $userID = $topic->getLastPostUserID();
            $time = date('j.n.Y k\l\o H:i', $topic->getLastPostTime());
            $newPosts = $topic->getNewPosts();
            $this->view->addTopic($topicGroup, $title, $topicID, $postCount, $user, $userID, $time, $newPosts);
        }
    }

    private function addPrivateMemberGroupTopics() {

    }

    public function getView() {
        return $this->view;
    }

    public function requireLogin() {
        return false;
    }

}
