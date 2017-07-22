<?php
    class playlists extends validation
    {

        /**
         * Constructor
         */

        public function __construct($playlist_name, $email)
        {

            $this->name          = $playlist_name;
            $this->email         = $email;
            $this->unique_string = $this->generate_unique_string();

        }

        /**
         * Method to generate unique string for the playlist
         *
         * @return $string
         */

        public function generate_unique_string()
        {

            $unique_string = md5(uniqid($this->email, true));

            return $unique_string;

        }

    }
?>
