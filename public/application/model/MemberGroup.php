<?php

namespace application\model;

defined('INDEX') or die;

class MemberGroup extends DatabaseObject {

    private $memberGroupID;
    private $name;
    private $memberCount;

    public function asArray() {
        return array(
            'id' => $this->memberGroupID,
            'name' => $this->name,
            'memberCount' => $this->memberCount
        );
    }

    public function createFromDatabaseRow(array $array) {
        $this->memberGroupID = $array['membergroupid'];
        $this->name = $array['groupname'];
        $this->memberCount = $array['membercount'] == null ? 0 : $array['membercount'];
    }

    public function getID() {
        return $this->memberGroupID;
    }

    public function getName() {
        return $this->name;
    }

    public function getMemberCount() {
        return $this->memberCount;
    }

}
