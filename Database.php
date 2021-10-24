<?php
    
    class Database
    {
        public function connection()
        {
            $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
            $dotenv->load();    
            
            
            $servername = $_ENV['ES_DB_SERVER'];
            $username = $_ENV['ES_DB_USR'];
            $password = $_ENV['ES_DB_PASS'];
            $dbname = $_ENV['ES_DB_NAME'];
            // $servername = getenv("ES_DB_SERVER");
            // $username = getenv("ES_DB_USR");
            // $password = getenv("ES_DB_PASS");
            // $dbname = getenv("ES_DB_NAME");

            
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            return $conn;
        }
    }
    



?>