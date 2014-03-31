<?php

namespace application\controller;

use application\controller\action\ActionHandler;
use application\controller\action\InvalidAction;
use application\controller\action\Login;
use application\controller\action\Logout;
use application\controller\action\Profile;
use application\controller\action\TopicList;
use application\model\Database;
use application\model\User;
use application\view\Renderer;
use application\view\Template;

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

        $this->actionHandler->addAction('login', new Login($this->request, $this->user));
        $this->actionHandler->addAction('logout', new Logout($this->user));
        $this->actionHandler->addAction('profile', new Profile($this->database, $this->request, $this->user));
    }

    private function renderPage() {
        $action = $this->actionHandler->getRequestedAction();
        
        $this->renderer->addGlobal('admin', $this->user->isAdmin());
        $this->renderer->addGlobal('loggedIn', $this->user->isLoggedIn());
        $this->renderer->addGlobal('username', $this->user->getUsername());
        $this->renderer->addGlobal('title', $action->getTitle());
        
        $action->setLocals();
        
        $page = $action->getView();
        $this->renderer->renderPage($page);
    }

}
