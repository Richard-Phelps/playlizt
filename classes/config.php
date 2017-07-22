<?php
    class config
    {

        /**
         * Constructor
         */

        public function __construct()
        {

            $this->site_url = 'http://192.168.33.10/personal-playlizt';
            $this->db_host  = 'localhost';
            $this->db_user  = 'root';
            $this->db_pass  = 'root';
            $this->db_name  = 'personal_playlizt';
            $this->charset  = 'utf8';

        }

        /**
         * Establish a connection to the database
         */
         
        public function db_connect()
        {

            // Set the options for PDO
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            // Try to connect to the database and catch the errors if it fails
            try {

                $connection = new PDO(
                    'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name . ';post=3306;charset=' . $this->charset,
                    $this->db_user,
                    $this->db_pass,
                    $options
                );

                return $connection;

            } catch (PDOException $error) {

                echo 'Connection failed: ' . $error->getMessage();

            }

        }

    }
?>
