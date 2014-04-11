<?php

namespace application\view;

defined('INDEX') or die;

/**
 * Renders the template and the actual page inside it
 */
class Renderer {

    private $vars;
    private $innerPage;

    /**
     * Adds a variable to the view
     * @param string $key
     * @param string $value
     */
    public function addVar($key, $value) {
        $this->vars[$key] = $value;
    }

    /**
     * Renders the given page
     * @param string $page
     */
    public function renderPage($page) {
        $this->innerPage = $page;
        require BASEDIR . '/application/view/template.php';
    }

}
