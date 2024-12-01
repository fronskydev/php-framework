<?php

namespace database;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;

class Connection
{
    private static ?Connection $instance = null;
    private \Doctrine\DBAL\Connection $conn;

    /**
     * Private constructor to create a new database connection using the provided environment variables.
     *
     * @throws Exception
     */
    private function __construct()
    {
        $config = new Configuration();
        $connectionParams = array(
            "dbname" => $_ENV["DB_DATABASE"],
            "user" => $_ENV["DB_USERNAME"],
            "password" => $_ENV["DB_PASSWORD"],
            "host" => $_ENV["DB_HOST"],
            "driver" => $_ENV["DB_CONNECTION"],
            "driverOptions" => [
                "encrypt" => "yes",
                "trustServerCertificate" => "yes",
            ]
        );
        $this->conn = DriverManager::getConnection($connectionParams, $config);
    }

    /**
     * Get the singleton instance of the Connection class.
     *
     * @return Connection|null The singleton instance of the Connection class, or null if not initialized.
     */
    public static function getInstance(): ?Connection
    {
        if(!self::$instance) {
            self::$instance = new Connection();
        }

        return self::$instance;
    }

    /**
     * Get the database connection instance.
     *
     * @return \Doctrine\DBAL\Connection The database connection instance.
     */
    public function getConnection(): \Doctrine\DBAL\Connection
    {
        return $this->conn;
    }
}