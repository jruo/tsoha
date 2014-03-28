<?php

namespace application\controller\action;

use application\controller\Request;
use application\model\User;

defined('INDEX') or die;

/**
 * Handles the user's requested actions
 */
class ActionHandler {

    private $request;
    private $user;
    private $actions;
    private $defaultAction;
    private $errorAction;

    /**
     * @param Request $request User's request
     */
    function __construct(Request $request, User $user) {
        $this->request = $request;
        $this->user = $user;
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
     * @param AbstractAction $errorAction Error Action
     */
    public function setErrorAction(AbstractAction $errorAction) {
        $this->errorAction = $errorAction;
    }

    /**
     * Executes the requested action
     */
    public function executeRequestedAction() {
        $action = $this->getRequestedAction();
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
