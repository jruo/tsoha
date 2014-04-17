<?php defined('INDEX') or die; ?>
<table class="table">
    <thead>
        <tr>
            <th>Jäsenryhmä</th>
            <th class="col-sm-2">Jäseniä</th>
            <th class="col-sm-1">Poista</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->vars['memberGroups'] as $membergroup) : ?>
            <tr>
                <td>
                    <a href="<?php echo BASEURL; ?>?action=admineditmembergroupmembers&id=<?php echo $membergroup['id']; ?>"><?php echo $membergroup['name']; ?></a>
                </td>
                <td>
                    ?
                </td>
                <td><a onclick="return confirm('Haluatko varmasti poistaa tämän jäsenryhmän? Tämä poistaa myös kaikki viestiketjut, jotka olivat näkyvissä vain tälle jäsenryhmälle!')" href="<?php echo BASEURL; ?>?action=admineditmembergroups&option=delete&groupid=<?php echo $membergroup['id']; ?>"<span style="color:black" class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<hr/>
<form method="GET" action="<?php echo BASEURL; ?>" role="form" class="form-horizontal">
    <input type="hidden" name="action" value="admineditmembergroups" />
    <input type="hidden" name="option" value="create" />
    <div class="form-group">
        <label for="groupName" class="control-label col-sm-2">Lisää uusi ryhmä:</label>
        <div class="col-sm-4">
            <input type="text" id="groupName" name="value" placeholder="Ryhmän nimi" class="form-control"/>
        </div>
        <div class="col-sm-1">
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Lisää</button>
        </div>
    </div>
</form>