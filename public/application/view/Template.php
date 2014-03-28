<?php

namespace application\view;

defined('INDEX') or die;

class Template implements Renderable {

    private $page;
    private $showAdminLink = false;
    private $username = null;

    function __construct(PageView $page) {
        $this->page = $page;
    }

    public function setUser($username) {
        $this->username = $username;
    }

    public function setAdmin($admin) {
        $this->showAdminLink = $admin;
    }

    public function render() {
        $adminLink = '';
        $userPanel = '<a class="forum-top-item" href="?action=login">Kirjaudu sisään</a>';
        $baseURL = BASEURL;

        if ($this->showAdminLink) {
            $adminLink = '
                    <a class="forum-top-item" href="?action=admin">Ylläpito</a>';
        }

        if (isset($this->username)) {
            $userPanel = <<<HTML
                    <span class="forum-top-item">Tervetuloa, </span>
                    <div class="dropdown">
                        <a data-toggle="dropdown" class="forum-top-item" href="#">{$this->username} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="?action=profile">Näytä profiili</a></li>
                            <li class="divider"></li>
                            <li><a href="?action=logout">Kirjaudu ulos</a></li>
                        </ul>
                    </div>
HTML;
        }

        echo <<<HTML
<!DOCTYPE html>
<html>
    <head>
        <title>{$this->page->getTitle()}</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{$baseURL}/css/bootstrap.min.css">
        <link rel="stylesheet" href="{$baseURL}/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="{$baseURL}/css/default.css">
    </head>
    <body>
        <div class="forum-top">
            <div class="container">
                <div class="forum-nav">
                    <a class="forum-top-item" href="{$baseURL}/">Etusivu</a>
                    <a class="forum-top-item" href="{$baseURL}/?action=newtopic">Aloita uusi viestiketju</a>
                    <a class="forum-top-item" href="{$baseURL}/?action=search">Hae</a>
                    {$adminLink}
                </div>
                <div class="forum-right">
                    {$userPanel}
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
        <script src="{$baseURL}/js/bootstrap.min.js"></script>
    </body>
</html>
HTML;
    }

}
