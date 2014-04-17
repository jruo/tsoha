<?php defined('INDEX') or die; ?>
<?php foreach ($this->vars['posts'] as $post) : ?>
    <div class="panel <?php echo $post['read'] ? 'panel-default' : 'panel-primary' ?> forum-post">
        <div class="panel-heading forum-post-heading">
            <div id="postid<?php echo $post['postNumber']; ?>">#<?php echo $post['postNumber']; ?>
                <?php if ($this->vars['loggedIn']) : ?>
                    <a href="javascript:reply(<?php echo $post['postNumber']; ?>);">Vastaa</a>
                <?php endif; ?>
                <?php if ($post['canEdit']) : ?>
                    | <a href="<?php echo BASEURL . "?action=editpost&id={$post['postID']}&topicid={$this->vars['topicID']}"; ?>">Muokkaa</a>
                <?php endif; ?>
                <?php if ($post['canDelete']) : ?>
                    | <a href="<?php echo BASEURL . "?action=deletepost&id={$post['postID']}"; ?>">Poista</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-sm-2">
                <small><?php echo $post['timeSent']; ?></small><br/>
                <a href="<?php echo BASEURL . "?action=profile&id={$post['userID']}"; ?>"><?php echo $post['username']; ?></a>
            </div>
            <div class="col-sm-10">
                <?php if (isset($post['replyToNumber'])) : ?>
                    <p><em><small>&gt; Vastaus viestiin <a href="#postid<?php echo $post['replyToNumber']; ?>">#<?php echo $post['replyToNumber']; ?></a></small></em></p>
                <?php endif; ?>
                <?php echo $post['content']; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php if ($this->vars['loggedIn']) : ?>
    <hr/>
    <div class="panel panel-default forum-post-reply">
        <div class="panel-body">
            <div class="col-sm-2">
                <small>Vastaa ketjuun</small>
            </div>
            <div class="col-sm-10">
                <form method="post" action="<?php echo BASEURL; ?>?action=newpost" role="form">
                    <input type="hidden" name="topicID" value="<?php echo $this->vars['topicID']; ?>"/>
                    <input type="hidden" name="replyToNumber" id="replyMessageInput" value="<?php echo isset($this->vars['replyToNumber']) ? $this->vars['replyToNumber'] : '-1'; ?>"/>
                    <div class="form-group">
                        <p><em><small id="replyMessage"><?php echo isset($this->vars['replyToNumber']) && $this->vars['replyToNumber'] != '-1' ? "Viesti lähetetään vastauksena viestiin #{$this->vars['replyToNumber']} <a href=\"javascript:reply(-1);\">(peruuta)</a>" : ''; ?></small></em></p>
                        <textarea required class="form-control" id="forum-post-reply-form" name="content" rows="5"><?php echo isset($this->vars['editPost']) ? $this->vars['editPost'] : ''; ?></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default" type="submit">Vastaa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>