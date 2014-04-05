<?php defined('INDEX') or die; ?>
<div class="panel panel-default forum-profile-info-panel">
    <div class="panel-body">
        <form class="form-horizontal" method="post" action="<?php echo BASEURL . '?action=editprofile&id=' . $this->vars['userID']; ?>" role="form">
            <div class="form-group">
                <label class="col-sm-2 control-label" for="inputEmail">Sähköposti</label>
                <div class="col-sm-4">
                    <input class="form-control" type="email" id="inputEmail" value="<?php echo $this->vars['email']; ?>"/>
                </div>
                <div class="col-sm-offset-2 col-sm-4">
                    <label class="control-label">Salasanan vaihto</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="inputRealName">Oikea nimi</label>
                <div class="col-sm-4">
                    <input class="form-control" type="text" id="inputRealName" value="<?php echo $this->vars['realName']; ?>"/>
                </div>
                <label class="col-sm-2 control-label" for="inputPasswordOld">Vanha salasana</label>
                <div class="col-sm-3">
                    <input class="form-control" type="password" id="inputPasswordOld"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="inputGender">Sukupuoli</label>
                <div class="col-sm-4">
                    <select id="inputGender" class="form-control">
                        <option value=""  <?php echo $this->vars['gender'] == 'null' ? 'selected' : ''; ?>>-</option>
                        <option value="1" <?php echo $this->vars['gender'] == '1' ? 'selected' : ''; ?>>Mies</option>
                        <option value="0" <?php echo $this->vars['gender'] == '0' ? 'selected' : ''; ?>>Nainen</option>
                    </select>
                </div>
                <label class="col-sm-2 control-label" for="inputPasswordNew1">Uusi salasana</label>
                <div class="col-sm-3">
                    <input class="form-control" type="password" id="inputPasswordNew1"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="inputAge">Ikä</label>
                <div class="col-sm-4">
                    <input class="form-control" type="text" id="inputAge" value="<?php echo $this->vars['age']; ?>"/>
                </div>
                <label class="col-sm-2 control-label" for="inputPasswordNew2">Salasana uudelleen</label>
                <div class="col-sm-3">
                    <input class="form-control" type="password" id="inputPasswordNew2"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button class="btn btn-default" type="submit">Tallenna muutokset</button>
                </div>
            </div>
        </form>
    </div>
</div>