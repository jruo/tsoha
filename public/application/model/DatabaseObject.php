<?php

namespace application\model;

defined('INDEX') or die;

abstract class DatabaseObject {

    /**
     * Creates this object from a database row
     * @param array $array
     */
    public abstract function createFromDatabaseRow(array $array);

    /**
     * Returns this object as an array
     * @return array
     */
    public abstract function asArray();

    /**
     * Creates an array of these objects from database rows
     * @param array $databaseRows
     * @return \static
     */
    public static function createArrayFromDatabase(array $databaseRows) {
        $array = array();
        foreach ($databaseRows as $row) {
            $entry = new static;
            $entry->createFromDatabaseRow($row);
            $array[] = $entry;
        }
        return $array;
    }

    /**
     * Creates a single object from a database row
     * @param array $databaseRows
     * @return \static|null
     */
    public static function createObjectFromDatabase(array $databaseRows) {
        if (count($databaseRows) < 1) {
            return null;
        }
        $row = $databaseRows[0];
        $object = new static;
        $object->createFromDatabaseRow($row);
        return $object;
    }

}
