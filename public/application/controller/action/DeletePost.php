<?php

namespace application\controller\action;

use application\controller\Redirect;
use application\controller\Request;
use application\model\Database;
use application\model\Post;
use application\model\User;

defined('INDEX') or die;

class DeletePost extends AbstractAction {

    private $database;
    private $request;
    private $user;

    function __construct(Database $database, Request $request, User $user) {
        $this->database = $database;
        $this->request = $request;
        $this->user = $user;
    }

    public function excute() {
        $postID = $this->request->getGetData('id');
        $post = new Post($this->database, $postID);
        if ($this->user->isAdmin()) {
            $post->delete();
        }

        // redirect back
        new Redirect($_SERVER['HTTP_REFERER']);
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
