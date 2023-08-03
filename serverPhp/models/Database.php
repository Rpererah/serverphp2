<?php
class Database {
    private $host;
    private $port;
    private $name;
    private $user;
    private $password;
    private $connection;

    public function __construct($host, $port, $name, $user, $password) {
        $this->host = $host;
        $this->port = $port;
        $this->name = $name;
        $this->user = $user;
        $this->password = $password;
    }

    public function connect() {
        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->name};";

        try {
            $this->connection = new PDO($dsn, $this->user, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }

        return $this->connection;
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>