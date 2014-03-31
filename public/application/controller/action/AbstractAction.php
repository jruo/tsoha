<?php

namespace application\controller\action;

use application\view\Renderer;

defined('INDEX') or die;

abstract class AbstractAction {
    
    /**
     * @var Renderer 
     */
    public $renderer;
    
    public function setRenderer(Renderer $renderer) {
        $this->renderer = $renderer;
    }

    /**
     * Executes this action
     */
    public abstract function excute();
    
    /**
     * Init the variables for the view;
     */
    public abstract function setVars();

    /**
     * Returns the file name of the view of this action
     */
    public abstract function getView();
    
    /**
     * Returns the title of this action
     */
    public abstract function getTitle();
    
    /**
     * Checks is this action needs the user to be logged in
     * @return boolean
     */
    public abstract function requireLogin();
}
