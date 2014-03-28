<?php

namespace application\controller\action;

use application\model\User;
use application\view\TopicListView;

defined('INDEX') or die;

class TopicList extends AbstractAction {

    private $view;
    private $user;

    function __construct(User $user) {
        $this->user = $user;
    }

    public function excute() {
        $this->view = new TopicListView();
        $this->addPublicTopics();
        if ($this->user->isLoggedIn()) {
            $this->addPrivateTopics();
        }
    }

    private function addPublicTopics() {
        $this->view->addTopicGroup(TopicListView::PUBLIC_GROUP);
        $this->view->addTopic(TopicListView::PUBLIC_GROUP, 'Viestiketjun otsikko', '1', '1', 'admin', '0', '27.3.2014 klo 18:01', '1');
    }

    private function addPrivateTopics() {
        $this->view->addTopicGroup(TopicListView::PRIVATE_GROUP);
        $this->view->addTopic(TopicListView::PRIVATE_GROUP, 'Sisäisen viestiketjun otsikko', '1', '1', 'admin', '0', '27.3.2014 klo 19:25', null);
    }

    public function getView() {
        return $this->view;
    }

    public function requireLogin() {
        return false;
    }

}
