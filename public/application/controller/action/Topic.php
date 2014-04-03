<?php

namespace application\controller\action;

use application\controller\Request;
use application\model\Database;
use application\model\PostLoader;
use application\model\User;

class Topic extends AbstractAction {

    private $database;
    private $request;
    private $user;
    private $topicID;

    function __construct(Database $database, Request $request, User $user) {
        $this->database = $database;
        $this->request = $request;
        $this->user = $user;
    }

    public function excute() {
        $this->topicID = $this->request->getGetData('id');
        
        if (!isset($this->topicID)) {
            header('location:' . BASEURL);
            die;
        }
        
        $loader = new PostLoader($this->database, $this->request);
        
        if (!$loader->canAccessTopic($topicID)) {
            // the user cannot access this topic
            header('location:' . BASEURL);
            die;
        }
        
        $topics = $loader->loadPosts($this->topicID);
    }

    public function setVars() {
        
    }

    public function getTitle() {
        
    }

    public function getView() {
        return 'topic.php';
    }

    public function requireLogin() {
        return false;
    }

}
