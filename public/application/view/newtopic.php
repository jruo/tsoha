<?php defined('INDEX') or die; ?>
<div class="panel panel-default">
    <div class="panel-body">
        <form role="form" method="post" action="<?php echo BASEURL; ?>?action=newtopic">
            <div class="form-group">
                <label for="inputTopicLocation">Viestiketjun näkyvyys</label>
                <div class="form-group">
                    <input type="checkbox" class="checkbox-inline" name="visibility-public" value="1"/> Julkinen<br>
                    <?php foreach ($this->vars['memberGroups'] as $memberGroup) : ?>
                        <input type="checkbox" class="checkbox-inline" name="visibility-<?php echo $memberGroup['id']; ?>" value="1"/> <?php echo $memberGroup['name']; ?><br>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputTitle">Viestiketjun otsikko</label>
                <input required type="text" class="form-control" id="inputTitle" placeholder="Otsikko" name="title" value="<?php echo isset($this->vars['topicTitle']) ? $this->vars['topicTitle'] : '' ?>">
            </div>
            <div class="form-group">
                <label for="inputContent">Viesti</label>
                <textarea required class="form-control" id="inputContent" rows="10" name="content"><?php echo isset($this->vars['topicContent']) ? $this->vars['topicContent'] : '' ?></textarea>
            </div>
            <button type="submit" class="btn btn-default">Lähetä</button>
        </form>
    </div>
</div>