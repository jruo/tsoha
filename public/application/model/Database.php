<?php

namespace application\model;

defined('INDEX') or die;

/**
 * The database
 */
class Database {

    private $pdo;
    private $lastSucceeded;

    public function __construct() {
        try {
            $this->pdo = new \PDO(DB_DNS);
        } catch (\PDOException $e) {
            die('Database connection failed');
        }
    }

    /**
     * Executes a query on the database
     * @param string $query Query
     * @param array $params Params
     * @return array Matching rows
     */
    public function query($query, array $params) {
        $databaseQuery = $this->pdo->prepare($query);
        $this->lastSucceeded = true;
        if (!$databaseQuery->execute($params)) {
            $this->lastSucceeded = false;
        }
        return $databaseQuery->fetchAll();
    }

    /**
     * Checks if the last query succeeded
     * @return boolean true or false
     */
    public function querySucceeded() {
        return $this->lastSucceeded;
    }

}
