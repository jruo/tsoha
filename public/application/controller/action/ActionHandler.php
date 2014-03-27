<?php

namespace application\controller\action;

use application\controller\Request;

defined('INDEX') or die;

class ActionHandler {

    private $request;
    private $actions;

    function __construct(Request $request) {
        $this->request = $request;
        $this->actions = array();
    }

    public function addAction($actionString, AbstractAction $action) {
        $this->actions[$actionString] = $action;
    }

    public function executeRequestedAction() {
        
    }

    public function getAction() {
        return $this->request->getAction();
    }

}
