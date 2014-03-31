<?php defined('INDEX') or die; ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $this->vars['title']; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo BASEURL; ?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo BASEURL; ?>css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo BASEURL; ?>css/default.css">
    </head>
    <body>
        <div class="forum-top">
            <div class="container">
                <div class="forum-nav">
                    <a class="forum-top-item" href="<?php echo BASEURL; ?>">Etusivu</a>
                    <a class="forum-top-item" href="<?php echo BASEURL; ?>?action=newtopic">Aloita uusi viestiketju</a>
                    <a class="forum-top-item" href="<?php echo BASEURL; ?>?action=search">Hae</a>
                    <?php if ($this->vars['admin']) : ?>
                        <a class="forum-top-item" href="<?php echo BASEURL; ?>?action=admin">Ylläpito</a>
                    <?php endif ?>
                </div>
                <div class="forum-right">
                    <?php if ($this->vars['loggedIn']): ?>
                        <span class="forum-top-item">Tervetuloa, </span>
                        <div class="dropdown">
                            <a data-toggle="dropdown" class="forum-top-item" href="#"><?php echo $this->vars['username']; ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo BASEURL; ?>?action=profile">Näytä profiili</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo BASEURL; ?>?action=logout">Kirjaudu ulos</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a class="forum-top-item" href="<?php echo BASEURL; ?>?action=login">Kirjaudu sisään</a>
                    <?php endif ?>
                </div>
                <div class="forum-clear"></div>
            </div>
        </div>
        <div class="container">
            <div class="page-header">
                <h1><?php echo $this->vars['title']; ?></h1>
            </div>
            <?php require $this->innerPage; ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="<?php echo BASEURL; ?>js/bootstrap.min.js"></script>
    </body>
</html>