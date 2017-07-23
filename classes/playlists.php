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
         *
         * @return int
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

            // If there are no errors
            if (count($temp_errors) > 0) {

                foreach ($temp_errors as $error) {
                    $errors->add_error($error);
                }

                // Redirect to the homepage as the errors are stored in the session
                header('Location: ' . $config->site_url);

                exit;

            } else {

                // Insert the playlist into the database
                $create_playlist_sql = "INSERT INTO
                                        playlists (unique_string, user_associated, user, email, created)
                                        VALUES (:us, '0', 0, :e, NOW())";

                $create_playlist     = $this->db->prepare($create_playlist_sql);
                $create_playlist->bindParam(':us', $this->unique_string);
                $create_playlist->bindParam(':e', $this->email);

                try {

                    $create_playlist->execute();

                    $get_playlist_id = $this->db->query("SELECT id FROM playlists WHERE unique_string = '$this->unique_string'");

                    return $get_playlist_id->fetchObject()->id;

                } catch(PDOException $e) {

                    $errors->add_error('There was an error creating the playlist, please try again later');

                    // Redirect to the homepage as the error is stored in the session
                    header('Location: ' . $config->site_url);

                    exit;

                }

            }

        }

    }
?>
