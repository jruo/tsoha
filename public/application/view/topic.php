<?php defined('INDEX') or die;

foreach ($this->vars['posts'] as $post) : ?>
<div class="panel <?php echo $post['read'] ? 'panel-default' : 'panel-primary'?> forum-post">
    <div class="panel-heading forum-post-heading">
        <div id="postid<?php echo $post['postNumber'];?>">#<?php echo $post['postNumber'];?> <a href="javascript:reply(<?php echo $post['postNumber'];?>);">Vastaa</a>
            <?php if ($post['canEdit']) : ?>
                | <a href="<?php echo BASEURL . "?action=editpost&id={$post['postID']}"; ?>">Muokkaa</a>
            <?php endif; if ($post['canDelete']) : ?>
                | <a href="<?php echo BASEURL . "?action=deletepost&id={$post['postID']}"; ?>">Poista</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-2">
            <small><?php echo $post['timeSent'];?></small><br/>
            <a href="<?php echo BASEURL . "?action=profile&id={$post['memberID']}";?>"><?php echo $post['username'];?></a>
        </div>
        <div class="col-sm-10">
            <?php echo $post['content'];?>
        </div>
    </div>
</div>
<?php endforeach; ?>

<hr>
<div class="panel panel-default forum-post-reply">
    <div class="panel-body">
        <div class="col-sm-2">
            <small>Vastaa ketjuun</small>
        </div>
        <div class="col-sm-10">
            <form method="post" action="<?php echo BASEURL; ?>?action=PLACEHOLDER&id=<?php echo $this->vars['topicID']; ?>" role="form">
                <input type="hidden" />
                <div class="form-group">
                    <p><em><small id="replyMessage"></small></em></p>
                    <textarea required class="form-control" id="forum-post-reply-form" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" type="submit">Vastaa</button>
                </div>
            </form>
        </div>
    </div>
</div>