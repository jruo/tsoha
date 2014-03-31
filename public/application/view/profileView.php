<?php defined('INDEX') or die; ?>
<div class="panel panel-default forum-profile-info-panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-2 forum-profile-info-header">Rekisteröitynyt:</div>
            <div class="col-md-10"><?php echo $this->locals['timeRegistered']; ?></div>
        </div><div class="row">
            <div class="col-md-2 forum-profile-info-header">Viestejä:</div>
            <div class="col-md-10"><?php echo $this->locals['postCount']; ?></div>
        </div><div class="row">
            <div class="col-md-2 forum-profile-info-header">Sähköposti:</div>
            <div class="col-md-10"><?php echo $this->locals['email']; ?></div>
        </div><div class="row">
            <div class="col-md-2 forum-profile-info-header">Oikea nimi:</div>
            <div class="col-md-10"><?php echo $this->locals['realName']; ?></div>
        </div><div class="row">
            <div class="col-md-2 forum-profile-info-header">Sukupuoli:</div>
            <div class="col-md-10"><?php echo $this->locals['gender']; ?></div>
        </div>
        <div class="row">
            <div class="col-md-2 forum-profile-info-header">Ikä:</div>
            <div class="col-md-10"><?php echo $this->locals['age']; ?></div>
        </div>
        <div class="row">
            <div class="col-md-offset-2 col-md-10"><a href="#">Muokkaa tietoja</a></div>
        </div>
    </div>
</div>