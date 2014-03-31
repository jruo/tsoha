<?php

namespace application\controller\action;

use application\controller\Request;
use application\model\User;
use application\view\Renderer;

defined('INDEX') or die;

/**
 * Handles the user's requested actions
 */
class ActionHandler {

    private $request;
    private $user;
    private $renderer;
    private $actions;
    private $defaultAction;
    private $errorAction;
    private $requestedAction;

    /**
     * @param Request $request User's request
     */
    function __construct(Request $request, User $user, Renderer $renderer) {
        $this->request = $request;
        $this->user = $user;
        $this->renderer = $renderer;
        $this->actions = array();
    }

    /**
     * Adds a new action
     * @param string $actionString Name of the action
     * @param AbstractAction $action Action
     */
    public function addAction($actionString, AbstractAction $action) {
        $this->actions[$actionString] = $action;
    }

    /**
     * Sets the default action
     * @param AbstractAction $action Default action
     */
    public function setDefaultAction(AbstractAction $action) {
        $this->defaultAction = $action;
    }

    /**
     * Sets the error action
     * @param AbstractAction $action Error Action
     */
    public function setErrorAction(AbstractAction $action) {
        $this->errorAction = $action;
    }

    /**
     * Executes the requested action
     */
    public function executeRequestedAction() {
        $action = $this->getRequestedAction();
        $action->setRenderer($this->renderer);
        
        if ($action->requireLogin() && !$this->user->isLoggedIn()) {
            // The user is not logged in, but the requested actions requires that
            $baseURL = BASEURL;
            header("location:{$baseURL}/?action=login&message=Tämä toiminto vaatii kirjautumisen");
            die;
        }
        $this->getRequestedAction()->excute();
    }

    /**
     * Returns the requested action
     * @return AbstractAction Requested action
     */
    public function getRequestedAction() {
        if (isset($this->requestedAction)) {
            return $this->requestedAction;
        }
        $action = $this->request->getAction();
        if (!isset($action) || empty($action)) {
            $this->requestedAction = $this->defaultAction; // no request, use the default action
        } else if (array_key_exists($action, $this->actions)) {
            $this->requestedAction = $this->actions[$action]; // valid request
        } else {
            $this->requestedAction = $this->errorAction; // invalid request
        }
        return $this->requestedAction;
    }

}
