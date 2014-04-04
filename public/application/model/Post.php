<?php

namespace application\model;

defined('INDEX') or die;

class Post {

    private $database;
    private $postID;
    private $postNumber;
    private $replyToNumber;
    private $memberID;
    private $username;
    private $content;
    private $timeSent;
    private $read;

    function __construct(Database $database, $postID, $postNumber = null, $replyToNumber = null, $memberID = null, $username = null, $content = null, $timeSent = null, $read = null) {
        $this->database = $database;
        $this->postID = $postID;
        $this->postNumber = $postNumber;
        $this->replyToNumber = $replyToNumber;
        $this->memberID = $memberID;
        $this->username = $username;
        $this->content = $content;
        $this->timeSent = $timeSent;
        $this->read = $read;

        if ($this->memberID == null) {
            $this->memberID = $this->loadMemberID();
        }
        if ($this->content == null) {
            $this->content = $this->loadContent();
        }
    }

    public function getPostID() {
        return $this->postID;
    }

    public function getPostNumber() {
        return $this->postNumber;
    }

    public function getReplyToNumber() {
        return $this->replyToNumber;
    }

    public function getMemberID() {
        return $this->memberID;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getContent() {
        return $this->content;
    }

    public function getTimeSent() {
        return $this->timeSent;
    }

    public function getRead() {
        return $this->read;
    }

    /**
     * Checks if the given user can delete this post
     * @param User $user
     * @return boolean
     */
    public function canDelete(User $user) {
        return $user->isAdmin(); // only admin can delete
    }

    /**
     * Checks if the given user can edit this post
     * @param User $user
     * @return type
     */
    public function canEdit(User $user) {
        // only admin or the owner of this post can edit
        return $user->isAdmin() || $user->getUserID() == $this->memberID;
    }

    /**
     * Deletes this post
     */
    public function delete() {
        $query = 'delete from post where postid=?;';
        $params = array($this->postID);
        $this->database->query($query, $params);
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

    private function loadMemberID() {
        $query = 'select memberid from post where postid=?;';
        $params = array($this->postID);
        $results = $this->database->query($query, $params);
        return $results[0]['memberid'];
    }
    
    private function loadContent() {
        $query = 'select content from post where postid=?;';
        $params = array($this->postID);
        $results = $this->database->query($query, $params);
        return $results[0]['content'];
    }

}
