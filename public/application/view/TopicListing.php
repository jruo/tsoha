<?php

namespace application\view;

defined('INDEX') or die;

class TopicListing extends PageView {
    
    public function render() {
        echo <<<HTML

HTML;
    }

    public function getTitle() {
        return 'Keskustelufoorumi';
    }

}
