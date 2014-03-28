<?php

namespace application\controller\action;

use application\controller\Request;

defined('INDEX') or die;

/**
 * Handles the user's requested actions
 */
class ActionHandler {

    private $request;
    private $actions;
    private $defaultAction;
    private $errorAction;

    /**
     * @param \application\controller\Request $request User's request
     */
    function __construct(Request $request) {
        $this->request = $request;
        $this->actions = array();
    }

    /**
     * Adds a new action
     * @param string $actionString Name of the action
     * @param \application\controller\action\AbstractAction $action Action
     */
    public function addAction($actionString, AbstractAction $action) {
        $this->actions[$actionString] = $action;
    }

    /**
     * Sets the default action
     * @param \application\controller\action\AbstractAction $action Default action
     */
    public function setDefaultAction(AbstractAction $action) {
        $this->defaultAction = $action;
    }

    /**
     * Sets the error action
     * @param \application\controller\action\AbstractAction $errorAction Error Action
     */
    public function setErrorAction(AbstractAction $errorAction) {
        $this->errorAction = $errorAction;
    }

    /**
     * Executes the requested action
     */
    public function executeRequestedAction() {
        $this->getRequestedAction()->excute();
    }

    /**
     * Returns the requested action
     * @return \application\controller\action\AbstractAction Requested action
     */
    public function getRequestedAction() {
        $action = $this->request->getAction();
        if (!isset($action) || empty($action)) {
            return $this->defaultAction; // no request, use the default action
        }
        if (array_key_exists($action, $this->actions)) {
            return $this->actions[$action]; // valid request
        } else {
            return $this->errorAction; // invalid request
        }
    }

}
