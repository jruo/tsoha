<?php

namespace application\controller\action;

use application\view\TopicListView;

defined('INDEX') or die;

class TopicList extends AbstractAction {

    public function excute() {

    }

    public function getView() {
        return new TopicListView();
    }

    public function requireLogin() {
        return false;
    }

}
