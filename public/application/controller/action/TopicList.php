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
        $this->topicLoader = new TopicLoader($database);
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
        foreach ($topics as $topic) {
            $title = $topic->getTitle();
            $topicID = $topic->getTopicID();
            $postCount = '-1';
            $user = $topic->getLastPostUsername();
            $userID = $topic->getLastPostUserID();
            $time = $topic->getLastPostTime();
            $newPosts = null;
            $this->view->addTopic(TopicListView::PUBLIC_GROUP, $title, $topicID, $postCount, $user, $userID, $time, $newPosts);
        }
    }

    private function addPrivateTopics() {
        $this->view->addTopicGroup(TopicListView::PRIVATE_GROUP);
        $this->view->addTopic(TopicListView::PRIVATE_GROUP, 'Sisäisen viestiketjun otsikko', '1', '1', 'admin', '0', '27.3.2014 klo 19:25', null);
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
