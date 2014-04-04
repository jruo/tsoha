<?php defined('INDEX') or die; ?>
<div class="panel panel-default forum-profile-info-panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-2 forum-profile-info-header">Rekisteröitynyt:</div>
            <div class="col-md-10"><?php echo $this->vars['timeRegistered']; ?></div>
        </div><div class="row">
            <div class="col-md-2 forum-profile-info-header">Viestejä:</div>
            <div class="col-md-10"><?php echo $this->vars['postCount']; ?></div>
        </div><div class="row">
            <div class="col-md-2 forum-profile-info-header">Sähköposti:</div>
            <div class="col-md-10"><?php echo $this->vars['email']; ?></div>
        </div><div class="row">
            <div class="col-md-2 forum-profile-info-header">Oikea nimi:</div>
            <div class="col-md-10"><?php echo $this->vars['realName']; ?></div>
        </div><div class="row">
            <div class="col-md-2 forum-profile-info-header">Sukupuoli:</div>
            <div class="col-md-10"><?php echo $this->vars['gender']; ?></div>
        </div>
        <div class="row">
            <div class="col-md-2 forum-profile-info-header">Ikä:</div>
            <div class="col-md-10"><?php echo $this->vars['age']; ?></div>
        </div>
        <?php if ($this->vars['canEdit']) : ?>
            <div class="row">
                <div class="col-md-offset-2 col-md-10"><a href="<?php echo BASEURL; ?>?action=editprofile&id=<?php echo $this->vars['userID']; ?>">Muokkaa tietoja</a></div>
            </div>
        <?php endif; ?>
    </div>
</div>