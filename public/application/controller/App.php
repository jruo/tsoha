<?php

namespace application\controller;

use application\controller\action\ActionHandler;
use application\controller\action\AdminPanel;
use application\controller\action\DeletePost;
use application\controller\action\EditPost;
use application\controller\action\EditProfile;
use application\controller\action\InvalidAction;
use application\controller\action\Login;
use application\controller\action\Logout;
use application\controller\action\NewPost;
use application\controller\action\NewTopic;
use application\controller\action\Profile;
use application\controller\action\Register;
use application\controller\action\Search;
use application\controller\action\Topic;
use application\controller\action\TopicList;
use application\model\Database;
use application\model\User;
use application\view\Renderer;

defined('INDEX') or die;

/**
 * Main application
 */
class App {

    private $database;
    private $request;
    private $actionHandler;
    private $user;
    private $renderer;

    public function run() {
        session_start();

        $this->database = new Database();
        $this->request = new Request();
        $this->user = new User($this->database);
        $this->renderer = new Renderer();

        $this->actionHandler = new ActionHandler($this->request, $this->user, $this->renderer);
        $this->addActions();
        $this->actionHandler->executeRequestedAction();

        $this->renderPage();
    }

    private function addActions() {
        $this->actionHandler->setDefaultAction(new TopicList($this->database, $this->user));
        $this->actionHandler->setErrorAction(new InvalidAction());

        $this->actionHandler->addAction('editprofile', new EditProfile($this->database, $this->request, $this->user));
        $this->actionHandler->addAction('deletepost', new DeletePost($this->database, $this->request, $this->user));
        $this->actionHandler->addAction('newtopic', new NewTopic($this->database, $this->request, $this->user));
        $this->actionHandler->addAction('editpost', new EditPost($this->database, $this->request, $this->user));
        $this->actionHandler->addAction('register', new Register($this->database, $this->request, $this->user));
        $this->actionHandler->addAction('profile', new Profile($this->database, $this->request, $this->user));
        $this->actionHandler->addAction('newpost', new NewPost($this->database, $this->request, $this->user));
        $this->actionHandler->addAction('topic', new Topic($this->database, $this->request, $this->user));
        $this->actionHandler->addAction('search', new Search($this->database, $this->request));
        $this->actionHandler->addAction('login', new Login($this->request, $this->user));
        $this->actionHandler->addAction('admin', new AdminPanel($this->user));
        $this->actionHandler->addAction('logout', new Logout($this->user));
    }

    private function renderPage() {
        $action = $this->actionHandler->getRequestedAction();

        $this->renderer->addVar('admin', $this->user->isAdmin());
        $this->renderer->addVar('loggedIn', $this->user->isLoggedIn());
        $this->renderer->addVar('username', $this->user->getUsername());
        $this->renderer->addVar('title', $action->getTitle());
        $this->renderer->addVar('message', $this->request->getGetData('message'));
        $this->renderer->addVar('info', $this->request->getGetData('info'));

        $action->setVars();

        $this->renderer->renderPage($action->getView());
    }

}
