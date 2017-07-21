<?php
    class config
    {

        /**
         * Constructor
         */
        public function __construct()
        {

            $this->site_url = 'http://192.168.33.10/personal-playlizt';
            $this->debug    = true;
            $this->db_host  = 'localhost';
            $this->db_user  = 'root';
            $this->db_pass  = 'root';
            $this->db_name  = 'personal_playlizt';

            $this->error_reporting();

        }

        /**
         * Method to deal with error reporting
         */
        public function error_reporting()
        {

            if ($debug) {
                ini_set('display_errors', 'on');
                error_reporting(E_ALL);
            }

        }

    }
?>
