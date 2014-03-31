<?php defined('INDEX') or die; ?>
<div class="panel panel-primary">
    <div class="panel-heading">Julkiset viestiketjut</div>
    <table class="table-striped table">
        <tr>
            <th>Viestiketju</th>
            <th class="col-md-1">Viestejä</th>
            <th class="col-md-4">Viimeisin vastaus</th>
        </tr>
        <?php foreach ($this->locals['publicTopics'] as $topic) : ?>
            <tr>
                <td>
                    <a href="/tsoha/?action=topic&id=<?php echo $topic['topicID']; ?>"><?php echo $topic['title']; ?></a>
                    <span class="badge"><?php echo $topic['newPosts']; ?></span>
                </td>
                <td><?php echo $topic['postCount']; ?></td>
                <td><a href="/tsoha/?action=profile&id=<?php echo $topic['userID']; ?>"><?php echo $topic['username']; ?></a>, <?php echo $topic['time']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php if ($this->globals['loggedIn']) : ?>
    <div class="panel panel-primary">
        <div class="panel-heading">Sisäiset viestiketjut</div>
        <table class="table-striped table">
            <tr>
                <th>Viestiketju</th>
                <th class="col-md-1">Viestejä</th>
                <th class="col-md-4">Viimeisin vastaus</th>
            </tr>
            <?php foreach ($this->locals['privateTopics'] as $topic) : ?>
                <tr>
                    <td>
                        <a href="/tsoha/?action=topic&id=<?php echo $topic['topicID']; ?>"><?php echo $topic['title']; ?></a>
                        <span class="badge"><?php echo $topic['newPosts']; ?></span>
                    </td>
                    <td><?php echo $topic['postCount']; ?></td>
                    <td><a href="/tsoha/?action=profile&id=<?php echo $topic['userID']; ?>"><?php echo $topic['username']; ?></a>, <?php echo $topic['time']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php endif;