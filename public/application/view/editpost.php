<?php defined('INDEX') or die; ?>
<div class="panel panel-default">
    <div class="panel-body">
        <form role="form" method="post" action="<?php echo BASEURL . "?action=editpost&id={$this->vars['postID']}&topicid={$this->vars['topicID']}"; ?>">
            <div class="form-group">
                <label for="inputContent">Viesti</label>
                <textarea required class="form-control" id="inputContent" rows="10" name="content"><?php echo isset($this->vars['newContent']) ? $this->vars['newContent'] : $this->vars['content']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-default">Tallenna muutokset</button>
        </form>
    </div>
</div>