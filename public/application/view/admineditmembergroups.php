<?php defined('INDEX') or die; ?>
<table class="table">
    <thead>
        <tr>
            <th>Jäsenryhmä</th>
            <th class="col-sm-1">Jäseniä</th>
            <th class="col-sm-2">Muuta nimeä</th>
            <th class="col-sm-1">Poista</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->vars['memberGroups'] as $memberGroup) : ?>
            <tr>
                <td>
                    <form role="form" action="<?php echo BASEURL; ?>" method="GET" class="form-inline">
                        <input type="hidden" name="action" value="admineditmembergroups" />
                        <input type="hidden" name="option" value="rename" />
                        <input type="hidden" name="groupid" value="<?php echo $memberGroup['id']; ?>" />
                        <div class="memberGroupRealName" id="memberGroupRealName-<?php echo $memberGroup['id']; ?>">
                            <a href="<?php echo BASEURL; ?>?action=admineditmembergroupmembers&id=<?php echo $memberGroup['id']; ?>"><?php echo $memberGroup['name']; ?></a>
                        </div>
                        <div class="memberGroupEditName" id="memberGroupEditName-<?php echo $memberGroup['id']; ?>" style="display:none">
                            <input class="form-control input-sm" style="width:50%" type="text" name="value" placeholder="<?php echo $memberGroup['name']; ?>" />
                            <button type="submit" class="btn-xs btn-default">Tallenna</button>
                            <button type="button" onclick="showRenameGroup(-1)" class="btn-xs btn-default">Peruuta</button>
                        </div>
                    </form>
                </td>
                <td>
                    <?php echo $memberGroup['memberCount']; ?>
                </td>
                <td>
                    <a href="javascript:showRenameGroup(<?php echo $memberGroup['id']; ?>)" style="color:black"><span class="glyphicon glyphicon-edit"></span></a>
                </td>
                <td><a onclick="return confirm('Haluatko varmasti poistaa tämän jäsenryhmän?')" href="<?php echo BASEURL; ?>?action=admineditmembergroups&option=delete&groupid=<?php echo $memberGroup['id']; ?>"<span style="color:black" class="glyphicon glyphicon-trash"></span></a></td>

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