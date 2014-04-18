<?php

namespace application\model;

defined('INDEX') or die;

class SearchResultLoader {

    private $database;
    private $user;
    private $query = array(null, null);
    private $userFilter = array(null, null);
    private $timeFilter = array(null, null);

    function __construct(Database $database, User $user) {
        $this->database = $database;
        $this->user = $user;
    }

    public function addQuery($query) {
        $this->query = array('and lower(content) like lower(?)', $query);
    }

    public function addUserFilter($username) {
        $this->userFilter = array('and lower(username)=lower(?)', $username);
    }

    public function addTimeFilter($time, $greater) {
        if ($greater) {
            $operator = '>';
        } else {
            $operator = '<';
        }
        $this->timeFilter = array("and timesent{$operator}?", $time);
    }

    public function search() {
        $query = <<<SQL
        select post.*, member.username
        from post, member
        where member.memberid=post.memberid
        and topicid in (
            select topicid
            from topic
            where topicid in (
                select topic.topicid
                from topic, topicvisible, memberofgroup
                where topic.topicid=topicvisible.topicid
                    and topicvisible.membergroupid=memberofgroup.membergroupid
                    and memberid=?
            )
                or public=1
                or ? in (
                    select memberid
                    from member
                    where admin=1
               )
        )
        {$this->query[0]}
        {$this->userFilter[0]}
        {$this->timeFilter[0]}
        order by timesent desc;
SQL;
        $params = array($this->user->getUserID(), $this->user->getUserID());
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

        return TopicPost::createArrayFromDatabase($results);
    }

}
