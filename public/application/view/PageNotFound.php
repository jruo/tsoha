<?php

namespace application\view;

defined('INDEX') or die;

class PageNotFound extends PageView {

    public function getTitle() {
        return '404 - Sivua ei löydy';
    }

    public function render() {
        echo '<a href="?">Takasin etusivulle</a>';
    }

}
