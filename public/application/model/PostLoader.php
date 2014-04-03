<?php

namespace application\model;

defined('INDEX') or die;

class PostLoader {
    
    private $database;
    private $user;
    
    function __construct(Database $database, User $user) {
        $this->database = $database;
        $this->user = $user;
    }
    
    /**
     * Checks if the user is allowed to read posts in the given topic
     * @param int $topicID
     */
    public function canAccessTopic($topicID) {
        // get user id (or -1 if not logged in)
        if ($this->user->isLoggedIn()) {
            $userID = $this->user->getUserID();
        } else {
            $userID = -1;
        }
        
        // get all the topics the user has access to
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
        $params = array($userID, $userID);
        $results = $this->database->query($query, $params);
        
        foreach ($results as $row) {
            if ($row['topicid'] == $topicID) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Loads all the posts in the given topic
     * @param int $topicID
     * @return array
     */
    public function loadPosts($topicID) {
        $query = <<<SQL
        select      post.postid, post.memberid, post.content, post.timesent,
                    member.username, post.postnumber, post.replytonumber
        from        post, member
        where       post.topicid=?
           and      post.memberid=member.memberid
        order by    post.postnumber asc;
SQL;
        $params = array($topicID);
        $results = $this->database->query($query, $params);
        
        return $this->parsePosts($results);
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
            $posts[] = new Post($postID, $postNumber, $replyToNumber, $memberID, $username, $content, $timesent);
        }
        
        return $posts;
    }

}
