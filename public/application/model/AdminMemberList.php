<?php

namespace application\model;

defined('INDEX') or die;

class AdminMemberList {

    private $database;

    function __construct(Database $database) {
        $this->database = $database;
    }

    public function getList() {
        $query = 'select memberid, username, admin, disabled from member order by memberid asc;';
        $params = array();
        $results = $this->database->query($query, $params);

        return AdminMemberListEntry::createArrayFromDatabase($results);
    }

}
