<?php

namespace application\view;

defined('INDEX') or die;

abstract class PageView implements Renderable {

    public $baseURL = BASEURL;

    public abstract function getTitle();
}
