<?php

namespace application\controller;

use application\model\Database;
use application\view\Template;
use application\view\TopicListing;

defined('INDEX') or die;

class App {
    
    private $database;
    
    public function run() {
        session_start();
        
        $this->database = new Database();
        
        $template = new Template(new TopicListing());
        $template->render();
    }
    
}
