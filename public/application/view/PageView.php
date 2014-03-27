<?php

namespace application\view;

defined('INDEX') or die;

abstract class PageView implements Renderable {
    
    public abstract function getTitle();
    
}
