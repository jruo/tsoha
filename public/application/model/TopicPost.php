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

}
