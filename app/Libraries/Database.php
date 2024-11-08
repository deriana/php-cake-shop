<?php
namespace Libraries;
use PDO;

class Database {
    private static $instance = NULL;

    // Constructor is private to prevent direct instantiation of the class
    public function __construct() {}

    // Clone method is private to prevent cloning of the instance
    private function __clone() {}

    // Static method to get the instance of the Database class (Singleton pattern)
    public static function getInstance() {
        // Check if the instance is already created
        if (!isset(self::$instance)) {
            // If not, create the PDO instance with connection options
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION; // Enable error mode for PDO
            // Create a new PDO connection and assign it to the $instance property
            self::$instance = new PDO('mysql:host=localhost;dbname=db_cake', 'root', 'root', $pdo_options);
        }
        // Return the PDO instance (Singleton instance)
        return self::$instance;
    }
}
?>
