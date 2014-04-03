<?php

namespace application\controller\action;

use application\controller\Request;
use application\model\Database;
use application\model\Post;
use application\model\Topic as TopicModel;
use application\model\User;

class Topic extends AbstractAction {

    private $database;
    private $request;
    private $user;
    private $topicID;
    private $title;
    private $posts;

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
        
        $loader = new TopicModel($this->database, $this->user, $this->topicID);
        
        if (!$loader->canAccess($this->topicID)) {
            // the user cannot access this topic or topic does not exist
            header('location:' . BASEURL . '?message=Virheellinen viestiketju');
            die;
        }
        
        $this->title = $loader->getTitle();
        $this->posts = $this->parsePosts($loader->loadPosts($this->topicID));
    }

    public function setVars() {
        $this->renderer->addVar('posts', $this->posts);
        $this->renderer->addVar('topicID', $this->topicID);
    }

    public function getTitle() {
        return $this->title;
    }

    public function getView() {
        return 'topic.php';
    }

    public function requireLogin() {
        return false;
    }
    
    private function parsePosts($posts) {
        $array = array();
        foreach ($posts as $post) {
            $postID = $post->getPostID();
            $postNumber = $post->getPostNumber();
            $replyToNumber = $post->getReplyToNumber();
            $memberID = $post->getMemberID();
            $username = $post->getUsername();
            $content = $post->getContent();
            $timeSent = date('j.n.Y k\l\o H:i', $post->getTimeSent());
            $read = $post->getRead() == 1;
            $canEdit = $post->canEdit($this->user);
            $canDelete = $post->canDelete($this->user);
            $array[] = array('postID' => $postID, 'postNumber' => $postNumber,
                'replyToNumber' => $replyToNumber, 'memberID' => $memberID,
                'username' => $username, 'content' => $content, 'read' => $read,
                'timeSent' => $timeSent, 'canEdit' => $canEdit, 'canDelete' => $canDelete);
        }
        return $array;
    }

}
