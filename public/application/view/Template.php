<?php

namespace application\view;

defined('INDEX') or die;

class Template implements Renderable {

    private $page;

    function __construct(PageView $page) {
        $this->page = $page;
    }

    public function render() {
        echo <<<HTML
<!DOCTYPE html>
<html>
    <head>
        <title>{$this->page->getTitle()}</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="./css/default.css">
    </head>
    <body>
        <div class="forum-top">
            <div class="container">
                <div class="forum-nav">
                    <a class="forum-top-item" href="?">Etusivu</a>
                    <a class="forum-top-item" href="?action=newtopic">Aloita uusi viestiketju</a>
                    <a class="forum-top-item" href="?action=search">Hae</a>
                    <a class="forum-top-item" href="?action=admin">Ylläpito</a>
                </div>
                <div class="forum-right">
                    <a class="forum-top-item" href="?action=login">Kirjaudu sisään</a>
                    <!--span class="forum-top-item">Tervetuloa, </span>
                    <div class="dropdown">
                        <a data-toggle="dropdown" class="forum-top-item" href="#">Matti Meikäläinen <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="?action=profile">Näytä profiili</a></li>
                            <li class="divider"></li>
                            <li><a href="?action=logout">Kirjaudu ulos</a></li>
                        </ul>
                    </div--!>
                </div>
                <div class="forum-clear"></div>
            </div>
        </div>
        <div class="container">
            <div class="page-header">
                <h1>{$this->page->getTitle()}</h1>
            </div>
HTML;
        $this->page->render();
        echo <<<HTML
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
    </body>
</html>
HTML;
    }

}
