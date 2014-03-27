<?php

namespace application\controller;

use application\controller\action\ActionHandler;
use application\controller\action\Login;
use application\model\Database;
use application\model\User;
use application\view\Template;
use application\view\TopicListing;

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

        $template = new Template(new TopicListing());
        $template->render();
    }

    private function addActions() {
        $this->actionHandler->addAction('login', new Login($this->request));
    }

}
