<?php

namespace application\controller\action;

use application\controller\Request;
use application\controller\Validator;
use application\model\Database;
use application\model\Post;
use application\model\User;

defined('INDEX') or die;

class EditPost extends AbstractAction {

    private $database;
    private $request;
    private $user;
    private $oldContent;
    private $topicID;
    private $postID;

    function __construct(Database $database, Request $request, User $user) {
        $this->database = $database;
        $this->request = $request;
        $this->user = $user;
    }

    public function excute() {
        $this->postID = $this->request->getGetData('id');
        $post = new Post($this->database, $this->postID);
        if (!$post->canEdit($this->user)) {
            header('location:' . BASEURL);
            die;
        }

        $this->topicID = $this->request->getGetData('topicid');
        if (!isset($this->topicID)) {
            header('location:' . BASEURL);
            die;
        }

        $newContent = $this->request->getPostData('content');

        if (isset($newContent)) {
            // the post was edited and the user saved changes
            if (!Validator::isValidPost($newContent)) {
                $_SESSION['newContent'] = $newContent;
                header('location:' . BASEURL . "?action=editpost&id={$this->postID}&topicid={$this->topicID}&message=Viestissä tulee olla vähintään 6 ja enintään 10,000 merkkiä");
                die;
            }
            $post->edit($newContent);
            header('location:' . BASEURL . '?action=topic&id=' . $this->topicID);
            die;
        }

        // the post wasn't edited yet
        $this->oldContent = $post->getContent();
    }

    public function setVars() {
        $this->renderer->addVar('content', $this->oldContent);
        $this->renderer->addVar('topicID', $this->topicID);
        $this->renderer->addVar('postID', $this->postID);
        if (isset($_SESSION['newContent'])) {
            $this->renderer->addVar('newContent', $_SESSION['newContent']);
            $_SESSION['newContent'] = null;
        }
    }

    public function getTitle() {
        return 'Muokkaa viestiä';
    }

    public function getView() {
        return 'editpost.php';
    }

    public function requireLogin() {
        return true;
    }

}
