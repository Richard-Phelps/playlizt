<?php
    class playlists extends validation
    {

        /**
         * Constructor
         */

        public function __construct($playlist_name, $email)
        {

            global $db;

            $this->db            = $db;
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

            $unique_string = substr(md5(uniqid($this->email, true)), 0, 10);

            // Check that the unique string isn't already being used
            $check_unique_string = $this->db->query("SELECT COUNT(*) AS count FROM playlists WHERE unique_string = '$unique_string'");

            if ($check_unique_string->fetchObject()->count == 0) {
                return $unique_string;
            } else {
                $this->generate_unique_string();
            }

        }

        /**
         * This method will create the playlist
         */

        public function create_playlist()
        {

            global $config;
            global $errors;

            $temp_errors = [];

            // Validate email address
            if (!$this->is_valid_email($this->email)) {
                $temp_errors[] = 'Sorry but the email you entered is not valid';
            }

            // Validate playlist name
            if (empty($this->name)) {
                $temp_errors[] = 'The playlist name must not be empty';
            }

            if (count($temp_errors) > 0) {

                foreach ($temp_errors as $error) {
                    $errors->add_error($error);
                }

                header('Location: ' . $config->site_url);

                exit;

            }

        }

    }
?>
