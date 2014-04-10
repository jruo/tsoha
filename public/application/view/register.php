<?php defined('INDEX') or die; ?>
<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="post" action="<?php echo BASEURL; ?>?action=register">
            <div class="form-group">
                <label for="username" class="col-sm-2 control-label">Käyttäjänimi</label>
                <div class="col-sm-10">
                    <input type="text" name="username" class="form-control" id="username" placeholder="Käyttäjänimi" required value="<?php echo isset($this->vars['returnUsername']) ? $this->vars['returnUsername'] : ''; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="password1" class="col-sm-2 control-label">Salasana</label>
                <div class="col-sm-10">
                    <input type="password" name="password1" class="form-control" id="password1" placeholder="Salasana" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password2" class="col-sm-2 control-label">Salasana uudelleen</label>
                <div class="col-sm-10">
                    <input type="password" name="password2" class="form-control" id="password2" placeholder="Salasana uudelleen" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Rekisteröidy</button>
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