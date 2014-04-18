<?php

namespace application\model;

defined('INDEX') or die;

/**
 * A post in a topic
 */
class TopicPost extends DatabaseObject {

    private $topicID;
    private $postID;
    private $postNumber;
    private $replyToNumber;
    private $userID;
    private $username;
    private $content;
    private $timeSent;
    private $read;

    public function asArray() {
        return array(
            'topicID' => $this->topicID,
            'postID' => $this->postID,
            'postNumber' => $this->postNumber,
            'replyToNumber' => $this->replyToNumber,
            'userID' => $this->userID,
            'username' => $this->username,
            'content' => $this->content,
            'timeSent' => $this->timeSent,
            'read' => $this->read
        );
    }

    public function createFromDatabaseRow(array $array) {
        $this->topicID = $array['topicid'];
        $this->postID = $array['postid'];
        $this->postNumber = $array['postnumber'];
        $this->replyToNumber = $array['replytonumber'];
        $this->userID = $array['memberid'];
        $this->username = $array['username'];
        $this->content = $array['content'];
        $this->timeSent = $array['timesent'];
        $this->read = isset($array['read']) ? $array['read'] : null;
    }

    public function getTopicID() {
        return $this->topicID;
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

    public function getUserID() {
        return $this->userID;
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

}
