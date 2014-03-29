<?php

namespace application\model;

defined('INDEX') or die;

class TopicLoader {

    private $database;
    private $user;

    function __construct(Database $database, User $user) {
        $this->database = $database;
        $this->user = $user;
    }

    public function getPublicTopics() {
        $query = <<<SQL
        select      topic.topicid, topic.title, member.username, member.memberid, post.timesent, count.count
        from        topic, post, member, (
                        select topicid, count(*)
                        from post
                        group by topicid
                    ) as count
        where       topic.topicid=post.topicid
            and     member.memberid=post.memberid
            and     topic.topicid=count.topicid
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

        return $this->parseTopics($results);
    }

    public function getPrivateTopics() {
        if (!$this->user->isLoggedIn()) {
            return;
        }
        $query = <<<SQL
        select      topic.topicid, topic.title, member.username, member.memberid, post.timesent, count.count
        from        topic, post, member, (
                        select topicid, count(*)
                        from post
                        group by topicid
                    ) as count
        where       topic.topicid=post.topicid
            and     member.memberid=post.memberid
            and     topic.topicid=count.topicid
            and     post.timesent=(
                        select max(post.timesent)
                        from post
                        where post.topicid=topic.topicid
                    )
            and     topic.topicid in (
                        select topicid
                        from topicvisible
                        where membergroupid in (
                            select membergroupid
                            from memberofgroup
                            where memberid=?
                        )
                    )
            and     topic.public=0
        order by    post.timesent desc;
SQL;
        $params = array($this->user->getUserID());
        $results = $this->database->query($query, $params);

        return $this->parseTopics($results);
    }

    private function parseTopics($databaseRows) {
        $topics = array();
        foreach ($databaseRows as $row) {
            $topics[] = new Topic($row['topicid'], $row['title'], $row['username'], $row['memberid'], $row['timesent'], $row['count']);
        }
        return $topics;
    }

}
