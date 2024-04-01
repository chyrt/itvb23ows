<?php

require_once './vendor/autoload.php';

class DatabaseSingleton {
    private static $instance = null;
    private $connection;

    private function __construct() {
        // Load environment variables
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        // Initialize database connection
        $this->connection = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);

        // Check connection
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new DatabaseSingleton();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function getInsertId() {
        return $this->connection->insert_id;
    }

    public function getState() {
        // Serialize and return the game state from the session
        return serialize([$_SESSION['hand'], $_SESSION['board'], $_SESSION['player']]);
    }

    public function setState($state) {
        // Deserialize the state and restore it to the session
        list($hand, $board, $player) = unserialize($state);
        $_SESSION['hand'] = $hand;
        $_SESSION['board'] = $board;
        $_SESSION['player'] = $player;
    }

    public function prepare($query) {
        return $this->connection->prepare($query);
    }

    // Prevent cloning and unserialization of the instance
    private function __clone() { }
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }
}