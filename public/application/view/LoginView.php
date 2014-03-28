<?php

namespace application\view;

defined('INDEX') or die;

class LoginView extends PageView {

    private $loginFailed = '';
    private $message = '';

    public function getTitle() {
        return 'Kirjaudu sisään';
    }

    public function setLoginFailed($display) {
        if (isset($display) && $display) {
            $this->loginFailed = '<div class="alert alert-danger">Väärä käyttäjänimi tai salasana</div>';
        }
    }

    public function setMessage($message) {
        if (isset($message)) {
            $this->message = "<div class=\"alert alert-warning\">{$message}</div>";
        }
    }

    public function render() {
        echo <<<HTML
        <div class="panel panel-default">
            <div class="panel-body">
                {$this->message}
                {$this->loginFailed}
                <form class="form-horizontal" role="form" method="post" action="?action=login">
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">Käyttäjänimi</label>
                        <div class="col-sm-10">
                            <input type="text" name="username" class="form-control" id="username" placeholder="Käyttäjänimi" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Salasana</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Salasana" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="remember" class="col-sm-2 control-label">Muista minut?</label>
                        <div class="col-sm-10">
                            <input type="checkbox" class="checkbox" id="remember">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Kirjaudu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
HTML;
    }

}
