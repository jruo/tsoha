<?php

namespace application\model;

defined('INDEX') or die;

class TopicListLoader {

    private $database;
    private $user;

    function __construct(Database $database, User $user) {
        $this->database = $database;
        $this->user = $user;
    }

    /**
     * Returns all the public Topics
     * @return array
     */
    public function getPublicTopics() {
        if ($this->user->isLoggedIn()) {
            $query = <<<SQL
            select      topic.topicid, topic.title, member.username, member.memberid, post.timesent, count.count, newcount.newcount
            from        topic, post, member, (
                            select topicid, count(*)
                            from post
                            group by topicid
                        ) as count, (
                            select distinct post.topicid, newcount.newcount
                            from post
                            left join (
                                select topicid, count(*) as newcount
                                from post
                                where postid not in (
                                    select postid
                                    from postread
                                    where memberid=?
                                )
                                group by topicid
                            ) as newcount
                            on post.topicid=newcount.topicid
                        ) as newcount
            where       topic.topicid=post.topicid
                and     member.memberid=post.memberid
                and     topic.topicid=count.topicid
                and     topic.topicid=newcount.topicid
                and     post.timesent=(
                            select max(post.timesent)
                            from post
                            where post.topicid=topic.topicid
                        )
                and     topic.public=1
            order by    post.timesent desc;
SQL;
            $params = array($this->user->getUserID());
        } else {
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
        }

        $results = $this->database->query($query, $params);

        return $this->parseTopics($results);
    }

    /**
     * Returns all the private topics
     * @return array
     */
    public function getPrivateTopics() {
        if (!$this->user->isLoggedIn()) {
            return;
        }
        $query = <<<SQL
        select      topic.topicid, topic.title, member.username, member.memberid, post.timesent, count.count, newcount.newcount
        from        topic, post, member, (
                        select topicid, count(*)
                        from post
                        group by topicid
                    ) as count, (
                        select distinct post.topicid, newcount.newcount
                        from post
                        left join (
                            select topicid, count(*) as newcount
                            from post
                            where postid not in (
                                select postid
                                from postread
                                where memberid=?
                            )
                            group by topicid
                        ) as newcount
                        on post.topicid=newcount.topicid
                    ) as newcount
        where       topic.topicid=post.topicid
            and     member.memberid=post.memberid
            and     topic.topicid=count.topicid
            and     topic.topicid=newcount.topicid
            and     post.timesent=(
                        select max(post.timesent)
                        from post
                        where post.topicid=topic.topicid
                    )
            and     (
                        topic.topicid in (
                            select topicid
                            from topicvisible
                            where membergroupid in (
                                select membergroupid
                                from memberofgroup
                                where memberid=?
                            )
                        )
                        or
                        ? in (
                            select memberid
                            from member
                            where admin=1
                        )
                    )
            and     topic.public=0
        order by    post.timesent desc;
SQL;
        $userID = $this->user->getUserID();
        $params = array($userID, $userID, $userID);
        $results = $this->database->query($query, $params);
        return $this->parseTopics($results);
    }

    private function parseTopics($databaseRows) {
        $topics = array();
        foreach ($databaseRows as $row) {
            if (isset($row['newcount'])) {
                $newcount = $row['newcount'];
            } else {
                $newcount = null;
            }
            $topics[] = new TopicListRow($row['topicid'], $row['title'], $row['username'], $row['memberid'], $row['timesent'], $row['count'], $newcount);
        }
        return $topics;
    }

}
