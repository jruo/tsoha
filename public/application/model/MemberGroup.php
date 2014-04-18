<?php

namespace application\model;

defined('INDEX') or die;

class MemberGroup {

    /**
     * Returns all membergroups the given user is member of
     * @param Database $database
     * @param int $userID
     * @return array
     */
    public static function getUsersGroups(Database $database, $userID) {
        $query = <<<SQL
        select      membergroup.membergroupid, membergroup.groupname
        from        membergroup, memberofgroup
        where       membergroup.membergroupid=memberofgroup.membergroupid
            and     memberid=?
        order by    membergroupid asc;
SQL;
        $params = array($userID);
        $results = $database->query($query, $params);
        return self::parseGroups($results);
    }

    /**
     * Returns all membergroups
     * @param Database $databse
     * @return array
     */
    public static function getGroups(Database $database) {
        $query = 'select * from membergroup order by membergroupid asc;';
        $params = array();
        $results = $database->query($query, $params);
        return self::parseGroups($results);
    }

    /**
     *
     * @param Database $database
     * @param string $groupName
     * @return boolean
     */
    public static function addGroup(Database $database, $groupName) {
        $query = 'insert into membergroup (groupname) values (?);';
        $params = array($groupName);
        $database->query($query, $params);
        return $database->querySucceeded();
    }

    /**
     *
     * @param Database $database
     * @param int $groupID
     * @param string $name
     * @return boolean
     */
    public static function renameGroup(Database $database, $groupID, $name) {
        $query = 'update membergroup set groupname=? where membergroupid=?;';
        $params = array($name, $groupID);
        $database->query($query, $params);
        return $database->querySucceeded();
    }

    /**
     *
     * @param Database $database
     * @param int $groupID
     * @return boolean
     */
    public static function removeGroup(Database $database, $groupID) {
        $query = 'delete from membergroup where membergroupid=?;';
        $params = array($groupID);
        $database->query($query, $params);
        return $database->querySucceeded();
    }

    /**
     *
     * @param Database $database
     * @param string $groupID
     * @param int $userID
     * @return boolean
     */
    public static function addUserToGroup(Database $database, $groupID, $userID) {
        $query = 'insert into memberofgroup values (?, ?);';
        $params = array($userID, $groupID);
        $database->query($query, $params);
        return $database->querySucceeded();
    }

    /**
     *
     * @param Database $database
     * @param type $groupID
     * @param type $userID
     */
    public static function removeUserFromGroup(Database $database, $groupID, $userID) {
        $query = 'delete from memberofgroup where memberid=? and membergroupid=?;';
        $params = array($userID, $groupID);
        $database->query($query, $params);
        return $database->querySucceeded();
    }

    private static function parseGroups($rows) {
        $groups = array();
        foreach ($rows as $row) {
            $group = array(
                'id' => $row['membergroupid'],
                'name' => $row['groupname']
            );
            $groups[] = $group;
        }
        return $groups;
    }

}
