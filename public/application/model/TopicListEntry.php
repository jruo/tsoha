<?php

namespace application\model;

defined('INDEX') or die;

/**
 * A topic in the front page listing
 */
class TopicListEntry extends DatabaseObject {

    private $topicID;
    private $title;
    private $lastPostUsername;
    private $lastPostUserID;
    private $lastPostTime;
    private $postCount;
    private $newPosts;

//    function __construct($topicID, $title, $lastPostUsername, $lastPostUserID, $lastPostTime, $postCount, $newPosts = null) {
//        $this->topicID = $topicID;
//        $this->title = $title;
//        $this->lastPostUsername = $lastPostUsername;
//        $this->lastPostUserID = $lastPostUserID;
//        $this->lastPostTime = $lastPostTime;
//        $this->postCount = $postCount;
//        $this->newPosts = $newPosts;
//    }

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

    public function getPostCount() {
        return $this->postCount;
    }

    public function getNewPosts() {
        return $this->newPosts;
    }

    public function asArray() {
        return array(
            'topicID' => $this->topicID,
            'title' => $this->title,
            'username' => $this->lastPostUsername,
            'userID' => $this->lastPostUserID,
            'time' => $this->lastPostTime,
            'postCount' => $this->postCount,
            'newPosts' => $this->newPosts
        );
    }

    public function createFromDatabaseRow(array $array) {
        $this->topicID = $array['topicid'];
        $this->title = $array['title'];
        $this->lastPostUsername = $array['username'];
        $this->lastPostUserID = $array['memberid'];
        $this->lastPostTime = $array['timesent'];
        $this->postCount = $array['count'];
        $this->newPosts = isset($array['newcount']) ? $array['newcount'] : null;
    }

}
