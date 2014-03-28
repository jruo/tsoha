<?php

namespace application\controller;

use application\controller\action\ActionHandler;
use application\controller\action\InvalidAction;
use application\controller\action\Login;
use application\controller\action\Logout;
use application\controller\action\TopicList;
use application\model\Database;
use application\model\User;
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

    public function run() {
        session_start();

        $this->database = new Database();
        $this->request = new Request();
        $this->actionHandler = new ActionHandler($this->request);
        $this->user = new User($this->database);

        $this->addActions();
        $this->actionHandler->executeRequestedAction();

        $this->renderPage();
    }

    private function addActions() {
        $this->actionHandler->setDefaultAction(new TopicList($this->user));
        $this->actionHandler->setErrorAction(new InvalidAction());

        $this->actionHandler->addAction('login', new Login($this->request, $this->user));
        $this->actionHandler->addAction('logout', new Logout($this->user));
    }

    private function renderPage() {
        $template = new Template($this->actionHandler->getRequestedAction()->getView());
        $template->setAdmin($this->user->isAdmin());
        $template->setUser($this->user->getUsername());
        $template->render();
    }

}
