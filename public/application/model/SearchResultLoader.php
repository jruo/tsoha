<?php

namespace application\model;

defined('INDEX') or die;

class SearchResultLoader {

    private $database;
    private $query = array(null, null);
    private $userFilter = array(null, null);
    private $timeFilter = array(null, null);

    function __construct(Database $database) {
        $this->database = $database;
    }

    public function addQuery($query) {
        $this->query = array(' and lower(content) like lower(?)', $query);
    }

    public function addUserFilter($username) {
        $this->userFilter = array(' and lower(username)=lower(?)', $username);
    }

    public function addTimeFilter($time, $greater) {
        if ($greater) {
            $operator = '>';
        } else {
            $operator = '<';
        }
        $this->timeFilter = array(" and timesent{$operator}?", $time);
    }

    public function search() {
        $query = 'select post.*, member.username from post, member where member.memberid=post.memberid'
                . $this->query[0] . $this->userFilter[0] . $this->timeFilter[0] . ' order by timesent desc;';
        $params = array();
        if ($this->query[1] != null) {
            $params[] = '%' . $this->query[1] . '%';
        }
        if ($this->userFilter[1] != null) {
            $params[] = $this->userFilter[1];
        }
        if ($this->timeFilter[1] != null) {
            $params[] = $this->timeFilter[1];
        }
        $results = $this->database->query($query, $params);
        return Post::parsePostsFromDatabaseRows($this->database, $results);
    }

}
