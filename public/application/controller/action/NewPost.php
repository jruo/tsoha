<?php

namespace application\controller\action;

use application\controller\Redirect;
use application\controller\Request;
use application\controller\Validator;
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
            new Redirect();
        }

        $topic = new Topic($this->database, $this->user, $topicID);

        if (!$topic->canAccess()) {
            // the user can't access this topic or it does not exist
            new Redirect(array('message' => 'Virheellinen viestiketju'));
        }

        if (!Validator::isValidPost($content)) {
            new Redirect(array(
                'action' => 'topic',
                'id' => $topicID,
                'message' => 'Viestissä tulee olla vähintään 6 ja enintään 10,000 merkkiä'
                    ), array(
                'editPost' => $content,
                'replyToNumber' => $replyToNumber
            ));
        }

        // ok
        Post::create($this->database, $this->user, $topicID, $replyToNumber == -1 ? null : $replyToNumber, $content);

        new Redirect(array('action' => 'topic', 'id' => $topicID));
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
