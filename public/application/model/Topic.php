<?php

namespace application\model;

defined('INDEX') or die;

/**
 * A topic in the front page listing
 */
class Topic {

    private $topicID;
    private $title;
    private $lastPostUsername;
    private $lastPostUserID;
    private $lastPostTime;

    function __construct($topicID, $title, $lastPostUsername, $lastPostUserID, $lastPostTime) {
        $this->topicID = $topicID;
        $this->title = $title;
        $this->lastPostUsername = $lastPostUsername;
        $this->lastPostUserID = $lastPostUserID;
        $this->lastPostTime = $lastPostTime;
    }

    public function getTopicID() {
        return $this->topicID;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getLastPostUsername() {
        return $this->lastPostUsername;
    }

    public function getLastPostUserID() {
        return $this->lastPostUserID;
    }

    public function getLastPostTime() {
        return $this->lastPostTime;
    }

}
