<?php defined('INDEX') or die; ?>
<table class="table">
    <thead>
        <tr>
            <th>Käyttäjä</th>
            <th class="col-sm-1">Ylläpitäjä</th>
            <th class="col-sm-1">Porttikiellossa</th>
            <th class="col-sm-1">Poista</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->vars['memberList'] as $member) : ?>
            <tr>
                <td>
                    <a href="<?php echo BASEURL; ?>?action=profile&id=<?php echo $member['userID']; ?>"><?php echo $member['username']; ?></a>
                </td>
                <td>
                    <?php if ($member['admin'] == 1) : ?>
                        <a href="<?php echo BASEURL; ?>?action=admineditmembers&option=setadmin&userid=<?php echo $member['userID']; ?>&value=0">
                            <span style="color:green" class="glyphicon glyphicon-ok"></span>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo BASEURL; ?>?action=admineditmembers&option=setadmin&userid=<?php echo $member['userID']; ?>&value=1">
                            <span style="color:red" class="glyphicon glyphicon-remove"></span>
                        </a>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($member['disabled'] == 1) : ?>
                        <a href="<?php echo BASEURL; ?>?action=admineditmembers&option=setban&userid=<?php echo $member['userID']; ?>&value=0">
                            <span style="color:green" class="glyphicon glyphicon-ok"></span>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo BASEURL; ?>?action=admineditmembers&option=setban&userid=<?php echo $member['userID']; ?>&value=1">
                            <span style="color:red" class="glyphicon glyphicon-remove"></span>
                        </a>
                    <?php endif; ?>
                </td>
                <td><a onclick="return confirm('Haluatko varmasti poistaa tämän jäsenen? Tämä poistaa myös kaikki jäseneen liittyvät tiedot, kuten kaikki jäsenen lähettämät viestit!')" href="<?php echo BASEURL; ?>?action=admineditmembers&option=delete&userid=<?php echo $member['userID']; ?>"<span style="color:black" class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>