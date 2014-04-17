<?php

namespace application\model;

defined('INDEX') or die;

class Post {

    private $database;
    private $postID;

    function __construct(Database $database, $postID) {
        $this->database = $database;
        $this->postID = $postID;
    }

    /**
     * Returns the userID of this post's writer
     * @return int
     */
    public function getUserID() {
        $query = 'select memberid from post where postid=?;';
        $params = array($this->postID);
        $results = $this->database->query($query, $params);
        return $results[0]['memberid'];
    }

    /**
     * Returns the content of this post
     * @return string
     */
    public function getContent() {
        $query = 'select content from post where postid=?;';
        $params = array($this->postID);
        $results = $this->database->query($query, $params);
        return $results[0]['content'];
    }

    /**
     * Deletes this post
     */
    public function delete() {
        $query = 'delete from post where postid=?;';
        $params = array($this->postID);
        $this->database->query($query, $params);
        Topic::deleteEmptyTopics($this->database); // this might have been the last post of the topic
    }

    /**
     * Edits this post
     * @param string $newContent
     */
    public function edit($newContent) {
        $query = 'update post set content=? where postid=?;';
        $params = array($newContent, $this->postID);
        $this->database->query($query, $params);
    }

    /**
     * Creates a new post
     * @param Database $database
     * @param User $user
     * @param int $topicID
     * @param int $replyToNumber
     * @param string $content
     */
    public static function create(Database $database, User $user, $topicID, $replyToNumber, $content) {
        $memberID = $user->getUserID();
        $timeSent = time();

        $query = <<<SQL
        insert into post (memberid, topicid, postnumber, replytonumber, content, timesent)
            select ?, ?, max(postnumber) + 1, ?, ?, ?
            from post
            where topicid=?;
SQL;
        $params = array($memberID, $topicID, $replyToNumber, $content, $timeSent, $topicID);
        $database->query($query, $params);
    }

}
