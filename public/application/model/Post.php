<?php

namespace application\model;

defined('INDEX') or die;

class Post {

    private $postid;
    private $postNumber;
    private $replyToNumber;
    private $memberID;
    private $username;
    private $content;
    private $timesent;

    function __construct($postid, $postNumber, $replyToNumber, $memberID, $username, $content, $timesent) {
        $this->postid = $postid;
        $this->postNumber = $postNumber;
        $this->replyToNumber = $replyToNumber;
        $this->memberID = $memberID;
        $this->username = $username;
        $this->content = $content;
        $this->timesent = $timesent;
    }

    public function getPostid() {
        return $this->postid;
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

    public function getTimesent() {
        return $this->timesent;
    }

}
