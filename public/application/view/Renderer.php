<?php

namespace application\view;

defined('INDEX') or die;

class Renderer {

    private $globals;
    private $locals;
    private $innerPage;

    public function addGlobal($key, $value) {
        $this->globals[$key] = $value;
    }

    public function addLocal($key, $value) {
        $this->locals[$key] = $value;
    }

    public function renderPage($page) {
        $this->innerPage = $page;
        require BASEDIR . '/application/view/template.php';
    }

}
