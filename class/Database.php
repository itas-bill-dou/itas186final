<?php

class Database
{
    protected static $instance;

    protected $db;

    protected $host;
    protected $user;
    protected $pass;
    protected $database;

    public static function getInstance(?string $dbName = null)
    {
        if (!isset(self::$instance)) self::$instance = new static($dbName);
        return self::$instance;
    }

    public function __construct(?string $dbName = null)
    {
        /**
         * If you use docker, uncomment out the following 2 lines
         */
        // $this->host = 'host.docker.internal';
        // $this->port = '9998';

        /**
         * If you use docker, comment out the following 2 lines
         */
        $this->host = 'localhost';
        $this->port = '3306';

        $this->user = 'root';
        $this->pass = '';
        $this->database = $dbName ?? 'marina';

        // Set DSN
        $dsn = "mysql:host={$this->host};dbname={$this->database};port={$this->port};charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        // Create PDO instance
        try {
            $this->db = new PDO($dsn, $this->user, $this->pass, $options);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public static function db(?string $dbName)
    {
        return static::getInstance($dbName)->db;
    }

    public function insert(string $sql, $data = [])
    {
        if ($data !== null) {
            $data = array_values($data);
        }
        $dbh = self::db($this->database);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
        return (int) $dbh->lastInsertId();
    }

    public function fetch(string $sql, $data = [], $class = null)
    {
        if ($data !== null) {
            $data = array_values($data);
        }

        $stmt = self::db($this->database)->prepare($sql);
        $stmt->execute($data);

        if ($class != null) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, $class);
        } else {
            $stmt->setFetchMode(PDO::FETCH_OBJ);
        }

        return $stmt->fetch();
    }

    public function fetchAll(string $sql, $data = [], $class = null)
    {
        if ($data !== null) {
            $data = array_values($data);
        }

        $stmt = self::db($this->database)->prepare($sql);
        $stmt->execute($data);

        if ($class != null) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, $class);
        } else {
            $stmt->setFetchMode(PDO::FETCH_OBJ);
        }

        return $stmt->fetchAll();
    }
}
