<?php defined('INDEX') or die; ?>
<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="post" action="<?php echo BASEURL; ?>?action=login">
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
                    <input type="checkbox" class="checkbox" id="remember" name="remember" value="true">
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
<script type="text/javascript">
    $(document).ready(function() {
        $("#username").focus();
    });
</script>