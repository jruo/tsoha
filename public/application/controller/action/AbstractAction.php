<?php

namespace application\controller\action;

defined('INDEX') or die;

abstract class AbstractAction {

    public abstract function activate();

    public abstract function getView();
}
