<?php

namespace application\controller\action;

use application\controller\Formatter;
use application\controller\Request;
use application\model\Database;
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

        $topic = new TopicModel($this->database, $this->user, $this->topicID);

        if (!$topic->canAccess()) {
            // the user cannot access this topic or topic does not exist
            header('location:' . BASEURL . '?message=Virheellinen viestiketju');
            die;
        }

        $this->title = Formatter::escapeText($topic->getTitle());
        $posts = $topic->loadPosts();
        $this->posts = $this->formatPosts($posts);
    }

    public function setVars() {
        $this->renderer->addVar('posts', $this->posts);
        $this->renderer->addVar('topicID', $this->topicID);
        if (isset($_SESSION['editPost'])) {
            $this->renderer->addVar('editPost', $_SESSION['editPost']);
            $_SESSION['editPost'] = null;
        }
        if (isset($_SESSION['replyToNumber'])) {
            $this->renderer->addVar('replyToNumber', $_SESSION['replyToNumber']);
            $_SESSION['replyToNumber'] = null;
        }
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

    private function formatPosts($posts) {
        $array = array();
        foreach ($posts as $post) {
            $postArray = $post->asArray();
            $postArray['content'] = Formatter::formatPostContent($postArray['content']);
            $postArray['timeSent'] = Formatter::formatTime($postArray['timeSent']);
            $postArray['canEdit'] = $this->user->isAdmin() || $this->user->getUserID() == $postArray['userID'];
            $postArray['canDelete'] = $this->user->isAdmin();
            $array[] = $postArray;
        }
        return $array;
    }

}
