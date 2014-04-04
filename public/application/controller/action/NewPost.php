<?php

namespace application\controller\action;

use application\controller\Request;
use application\model\Database;
use application\model\Post;
use application\model\Topic;
use application\model\User;

defined('INDEX') or die;

class NewPost extends AbstractAction {

    private $database;
    private $request;
    private $user;

    function __construct(Database $database, Request $request, User $user) {
        $this->database = $database;
        $this->request = $request;
        $this->user = $user;
    }

    public function excute() {
        $topicID = $this->request->getPostData('topicID');
        $replyToNumber = $this->request->getPostData('replyToNumber');
        $content = $this->request->getPostData('content');

        if (!isset($topicID, $replyToNumber, $content)) {
            header('location:' . BASEURL);
            die;
        }

        $topic = new Topic($this->database, $this->user, $topicID);
        
        if (!$topic->canAccess()) {
            header('location:' . BASEURL);
            die;
        }
        
        Post::create($this->database, $this->user, $topicID, $replyToNumber, $content);
        
        header('location:' . $_SERVER['HTTP_REFERER']);
    }

    public function setVars() {
        
    }

    public function getTitle() {
        return null;
    }

    public function getView() {
        return null;
    }

    public function requireLogin() {
        return true;
    }

}
