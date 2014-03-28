<?php

namespace application\controller\action;

defined('INDEX') or die;

abstract class AbstractAction {

    /**
     * Executes this action
     */
    public abstract function excute();

    /**
     * Returns the view of this action
     * @return \application\view\PageView
     */
    public abstract function getView();

    /**
     * Checks whether this actions needs the user to be logged in or not
     * @return boolean
     */
    public abstract function requireLogin();
}
