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
