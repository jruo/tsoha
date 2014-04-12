<?php defined('INDEX') or die; ?>
<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="post" action="<?php echo BASEURL; ?>?action=search">
            <div class="form-group">
                <label for="inputQuery" class="col-sm-2 control-label">Hakusana</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputQuery" name="query" placeholder="Hakusana">
                </div>
            </div>

            <div class="form-group">
                <label for="inputTimeFilter" class="col-sm-2 control-label">Hae ajalta</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <select name="timeSelect">
                                <option value="none">Mikä tahansa</option>
                                <option value="before">Ennen</option>
                                <option value="after">Jälkeen</option>
                            </select>
                        </span>
                        <input type="text" id="inputTimeFilter" class="form-control" name="timeInput" placeholder="YYYY-MM-DD hh:mm:ss">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="inputMemberFilter" class="col-sm-2 control-label">Hae käyttäjältä</label>
                <div class="col-sm-10">
                    <input type="text" id="inputMemberFilter" class="form-control" name="username" placeholder="Nimi">
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
<?php if ($this->vars['hasResults']) : ?>
    <hr/>
    <h2>Hakutulokset</h2>
    <hr/>
    <?php if ($this->vars['posts'] == null) : ?>
        Ei tuloksia.
    <?php endif; ?>
    <?php foreach ($this->vars['posts'] as $post) : ?>
        <div class="panel panel-default forum-post">
            <div class="panel-heading forum-post-heading">
                <div>
                    <a href="<?php echo BASEURL; ?>?action=topic&id=<?php echo $post['topicID']; ?>#postid<?php echo $post['postNumber']; ?>">Mene viestiketjuun</a>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-2">
                    <small><?php echo $post['timeSent']; ?></small><br/>
                    <a href="<?php echo BASEURL . "?action=profile&id={$post['memberID']}"; ?>"><?php echo $post['username']; ?></a>
                </div>
                <?php echo $post['content']; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>