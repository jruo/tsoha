<?php defined('INDEX') or die; ?>
<table class="table">
    <thead>
        <tr>
            <th>Käyttäjä</th>
            <th class="col-sm-1">Poista</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($this->vars['members'])) : ?>
            <?php foreach ($this->vars['members'] as $member) : ?>
                <tr>
                    <td>
                        <a href="<?php echo BASEURL; ?>?action=profile&id=<?php echo $member['id']; ?>"><?php echo $member['username']; ?></a>
                    </td>
                    <td><a onclick="return confirm('Poistetaanko jäsen ryhmästä?')" href="<?php echo BASEURL; ?>?action=admineditmembergroupmembers&option=delete&id=<?php echo $this->vars['groupID']; ?>&value=<?php echo $member['id']; ?>"<span style="color:black" class="glyphicon glyphicon-trash"></span></a></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<hr/>
<form method="GET" action="<?php echo BASEURL; ?>" role="form" class="form-horizontal">
    <input type="hidden" name="action" value="admineditmembergroupmembers" />
    <input type="hidden" name="option" value="add" />
    <input type="hidden" name="id" value="<?php echo $this->vars['groupID']; ?>" />
    <div class="form-group">
        <label for="usernameame" class="control-label col-sm-2">Lisää jäsen ryhmään:</label>
        <div class="col-sm-4">
            <input type="text" id="username" name="value" placeholder="Jäsenen nimi" class="form-control"/>
        </div>
        <div class="col-sm-1">
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Lisää</button>
        </div>
    </div>
</form>