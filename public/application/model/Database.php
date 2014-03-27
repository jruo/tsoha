<?php

namespace application\model;

defined('INDEX') or die;

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
    
    public function query($queryString, array $params) {
        $query = $this->pdo->prepare($queryString);
        $this->lastSucceeded = true;
        if (!$query->execute($params)) {
            $this->lastSucceeded = false;
        }
        return $query->fetchAll();
    }
    
    public function querySucceeded() {
        return $this->lastSucceeded;
    }
    
}
