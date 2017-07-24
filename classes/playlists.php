<?php
    class playlists extends validation
    {

        /**
         * Constructor
         */

        public function __construct($playlist_name = '', $email = '')
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
         * This method will get the unique string for the playlist
         *
         * @param  $id: The playlist id to get the unique string for
         *
         * @return string
         */

        public function get_unique_string($id)
        {

            $unique_string = $this->db->query("
                SELECT unique_string
                FROM playlists
                WHERE id = '$id'
            ");

            return $unique_string->fetchObject()->unique_string;

        }

        /**
         * This method will create the playlist
         *
         * @return int
         */

        public function create_playlist()
        {

            global $errors, $config;

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
                                        playlists (unique_string, name, user_associated, user, email, created)
                                        VALUES (:us, :n, '0', 0, :e, NOW())";
                $create_playlist     = $this->db->prepare($create_playlist_sql);

                $create_playlist->bindParam(':us', $this->unique_string);
                $create_playlist->bindParam(':n', $this->name);
                $create_playlist->bindParam(':e', $this->email);

                try {

                    $create_playlist->execute();

                    $get_playlist_id = $this->db->query("SELECT id FROM playlists WHERE unique_string = '$this->unique_string'");

                    return $get_playlist_id->fetchObject()->id;

                } catch (PDOException $e) {

                    $errors->add_error('There was an error creating the playlist, please try again later');

                    // Redirect to the homepage as the error is stored in the session
                    header('Location: ' . $config->site_url);

                    exit;

                }

            }

        }

        /**
         * This method will add a video to the playlist
         *
         * @param $playlist_id: The id of the playlist to add the video to
         * @param $video_id   : The youtube video id
         * @param $start      : How many seconds into the video it should start playing
         */

        public function add_video($playlist_id, $video_id, $start)
        {

            global $errors, $config;

            // Make sre that the playlist id is not empty and is not 0
            if (!empty($playlist_id) && $playlist_id != 0) {

                // Make sure each parameter is set
                if (isset($playlist_id) && isset($video_id) && isset($start)) {

                    // Ensure the video hasn't already been added to the playlist
                    $check_video = $this->db->query("
                        SELECT COUNT(*) AS count
                        FROM playlist_videos
                        WHERE playlist_id = '$playlist_id'
                        AND video_id = '$video_id'
                    ");

                    if ($check_video->fetchObject()->count == 0) {

                        // Add the video to the playlist_videos table
                        $add_video_sql = "INSERT INTO playlist_videos (playlist_id, video_id, start, added) VALUES (:pid, :vid, :s, NOW())";
                        $add_video     = $this->db->prepare($add_video_sql);

                        $add_video->bindParam(':pid', $playlist_id);
                        $add_video->bindParam(':vid', $video_id);
                        $add_video->bindParam(':s', $start);

                        try {

                            $add_video->execute();
                            echo 'success';

                        } catch (PDOException $e) {

                            $errors->add('Sorry but something went wrong when adding the video to the playlist, please try again later');
                            header('Location: ' . $config->site_url . '/create-playlist/');
                            exit;

                        }

                    } else {

                        $errors->add('Sorry but this song has already been added to the playlist');
                        header('Location: ' . $config->site_url . '/create-playlist/');
                        exit;

                    }

                } else {

                    $errors->add('Sorry but some parameters are empty');
                    header('Location: ' . $config->site_url . '/create-playlist/');
                    exit;

                }

            } else {

                $errors->add('Sorry but a playlist has to have been created to add this video');
                header('Location: ' . $config->site_url . '/create-playlist/');
                exit;

            }

        }

    }
?>
