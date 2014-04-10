<?php defined('INDEX') or die; ?>
<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="post" action="#">
            <div class="form-group">
                <label for="inputQuery" class="col-sm-2 control-label">Hakusana</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputQuery" placeholder="Hakusana">
                </div>
            </div>

            <div class="form-group">
                <label for="inputTimeFilter" class="col-sm-2 control-label">Hae ajalta</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <select>
                                <option value="none">Mikä tahansa</option>
                                <option value="before">Ennen</option>
                                <option value="after">Jälkeen</option>
                            </select>
                        </span>
                        <input type="text" id="inputTimeFilter" class="form-control" placeholder="DD.MM.YYYY HH:MM">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="inputMemberFilter" class="col-sm-2 control-label">Hae käyttäjältä</label>
                <div class="col-sm-10">
                    <input type="text" id="inputMemberFilter" class="form-control" placeholder="Nimi">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Hae</button>
                </div>
            </div>
        </form>
    </div>
</div>