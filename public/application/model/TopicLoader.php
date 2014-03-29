<?php

namespace application\model;

defined('INDEX') or die;

class TopicLoader {

    private $database;

    function __construct(Database $database) {
        $this->database = $database;
    }

    public function getPublicTopics() {
        $query = <<<SQL
        select      topic.topicid, topic.title, member.username, member.memberid, post.timesent
        from        topic, post, member
        where       topic.topicid=post.topicid
            and     member.memberid=post.memberid
            and     post.timesent=(
                        select max(post.timesent)
                        from post
                        where post.topicid=topic.topicid
                    )
            and     topic.public=1
        order by    post.timesent desc;
SQL;
        $params = array();
        $results = $this->database->query($query, $params);

        $topics = array();
        foreach ($results as $row) {
            $topics[] = new Topic($row['topicid'], $row['title'], $row['username'], $row['memberid'], $row['timesent']);
        }
        return $topics;
    }

}
