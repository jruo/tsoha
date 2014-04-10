<?php

namespace application\model;

defined('INDEX') or die;

class Topic {

    private $database;
    private $user;
    private $topicID;
    private $userID;

    function __construct(Database $database, User $user, $topicID) {
        $this->database = $database;
        $this->user = $user;
        $this->topicID = $topicID;

        if ($this->user->isLoggedIn()) {
            $this->userID = $this->user->getUserID();
        } else {
            $this->userID = -1;
        }
    }

    public function getTitle() {
        $query = 'select title from topic where topicid=?;';
        $params = array($this->topicID);
        $results = $this->database->query($query, $params);
        return $results[0]['title'];
    }

    /**
     * Checks if the user is allowed to read posts in the topic
     */
    public function canAccess() {
        $query = <<<SQL
        select      topicid
        from        topic
        where       topicid in (
                        select topic.topicid
                        from topic, topicvisible, memberofgroup
                        where topic.topicid=topicvisible.topicid
                            and topicvisible.membergroupid=memberofgroup.membergroupid
                            and memberid=?
                    )
            or      public=1
            or      ? in (
                        select memberid
                        from member
                        where admin=1
                    );
SQL;
        $params = array($this->userID, $this->userID);
        $results = $this->database->query($query, $params);

        foreach ($results as $row) {
            if ($row['topicid'] == $this->topicID) {
                return true;
            }
        }
        return false;
    }

    /**
     * Loads all the posts in the topic
     * @return array
     */
    public function loadPosts() {
        // load posts
        $query = <<<SQL
        select      post.postid, post.memberid, post.topicid, post.content, post.timesent,
                    member.username, read.read, post.postnumber, post.replytonumber
        from        post
        inner join  member
            on      post.memberid=member.memberid
        left join   (
                        select postid, 1 as read
                        from postread
                        where memberid=?
                    ) as read
            on      post.postid=read.postid
        where       post.topicid=?
        order by    post.postnumber asc;
SQL;
        $params = array($this->userID, $this->topicID);
        $results = $this->database->query($query, $params);

        // mark all posts as read from the topic
        $query = <<<SQL
        insert into postread
            select  postid, ? as memberid
            from    post
            where   topicid=?
                and     postid not in (
                            select postid
                            from postread
                            where memberid=?
                        );
SQL;
        $params = array($this->userID, $this->topicID, $this->userID);
        if ($this->userID > 0) {
            $this->database->query($query, $params);
        }

        return $this->parsePosts($results);
    }

    public function giveAccessToGroup($groupID) {
        $query = 'insert into topicvisible values (?, ?);';
        $params = array($this->topicID, $groupID);
        $this->database->query($query, $params);
        return $this->database->querySucceeded();
    }

    public function getID() {
        return $this->topicID;
    }

    /**
     * Creates a new topic
     * @param Database $database
     * @param User $user
     * @param string $title
     * @param string $content
     * @param int $public
     * @return Topic
     */
    public static function create(Database $database, User $user, $title, $content, $public) {
        $query = 'insert into topic (title, public) values (?, ?) returning topicid;';
        $params = array($title, $public);
        $results = $database->query($query, $params);
        $topicID = $results[0]['topicid'];

        if (!$database->querySucceeded()) {
            return null;
        }

        $query = 'insert into post (memberid, topicid, postnumber, replytonumber, content, timesent) values (?, ?, ?, NULL, ?, ?);';
        $params = array($user->getUserID(), $topicID, 1, $content, time());
        $database->query($query, $params);

        if ($database->querySucceeded()) {
            return new self($database, $user, $topicID);
        }
        return null;
    }
    
    public static function deleteEmptyTopics(Database $database) {
        $query = <<<SQL
        delete from topic
        where topicid in (
            select topicid
            from (
                select topic.topicid, coalesce(postcount, 0) as postcount
                from topic
                left join (
                    select topicid, count(*) as postcount
                    from post
                    group by topicid
                ) as postcount
                on topic.topicid=postcount.topicid
            ) as topicpostcount
            where postcount=0
        );
SQL;
        $params = array();
        $database->query($query, $params);
    }

    private function parsePosts(array $results) {
        $posts = array();

        foreach ($results as $row) {
            $postID = $row['postid'];
            $memberID = $row['memberid'];
            $content = $row['content'];
            $timesent = $row['timesent'];
            $username = $row['username'];
            $postNumber = $row['postnumber'];
            $replyToNumber = $row['replytonumber'];
            $read = $row['read'];
            $posts[] = new Post($this->database, $postID, $postNumber, $replyToNumber, $memberID, $username, $content, $timesent, $read);
        }

        return $posts;
    }

}
