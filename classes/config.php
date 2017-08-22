<?php
    class config
    {

        /**
         * Constructor
         */

        public function __construct()
        {

            $this->site_url = '';
            $this->db_host  = '';
            $this->db_user  = '';
            $this->db_pass  = '';
            $this->db_name  = '';
            $this->charset  = 'utf8';

        }

        /**
         * Establish a connection to the database
         *
         * @return object
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

            } catch (PDOException $e) {

                echo 'Connection failed: ' . $e->getMessage();

            }

        }

        /**
         * This metod will print_r anything and put pre tags around it to make it easier to read
         *
         * @param $input: What it is that needs to be passed into print_r
         */

        public function debug($input)
        {

            echo '<pre>';
            print_r($input);
            echo '</pre>';

        }

    }
?>
