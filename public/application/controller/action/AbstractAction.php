<?php

namespace application\controller\action;

use application\view\Renderer;

defined('INDEX') or die;

abstract class AbstractAction {
    
    /**
     * @var Renderer 
     */
    public $renderer;
    
    /**
     * Sets the renderer for this action
     * @param Renderer $renderer
     */
    public function setRenderer(Renderer $renderer) {
        $this->renderer = $renderer;
    }

    /**
     * Executes this action
     */
    public abstract function excute();
    
    /**
     * Init the variables for the renderer;
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
     * Returns true if this action needs a valid logged in user
     * @return boolean
     */
    public abstract function requireLogin();
}
