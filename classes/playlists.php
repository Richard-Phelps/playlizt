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

            $unique_string = $this->db->query("SELECT unique_string FROM playlists WHERE id = '$id'");

            return $unique_string->fetchObject()->unique_string;

        }

        /**
         * This method will get the playlist id from the unique string
         *
         * @param $unique_string: The unique string for the playlist to get the id from
         *
         * @return int
         */

        public function get_id($unique_string)
        {

            $id = $this->db->query("SELECT id FROM playlists WHERE unique_string = '$unique_string'");
            return $id->fetchObject()->id;

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

                $create_playlist->bindParam(':us', $this->unique_string, PDO::PARAM_STR);
                $create_playlist->bindParam(':n', $this->name, PDO::PARAM_STR);
                $create_playlist->bindParam(':e', $this->email, PDO::PARAM_STR);

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
         * @param $order      : The order for this video
         */

        public function add_video($playlist_id, $video_id, $start, $order)
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
                        $add_video_sql = "INSERT INTO playlist_videos (playlist_id, video_id, start, video_order, added) VALUES (:pid, :vid, :s, :o, NOW())";
                        $add_video     = $this->db->prepare($add_video_sql);

                        $add_video->bindParam(':pid', $playlist_id, PDO::PARAM_INT);
                        $add_video->bindParam(':vid', $video_id, PDO::PARAM_STR);
                        $add_video->bindParam(':s', $start, PDO::PARAM_INT);
                        $add_video->bindParam(':o', $order, PDO::PARAM_INT);

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

        /**
         * This method will save the password for editing the playlist
         *
         * @param $playlist_id: The playlist to save the password against
         * @param $password   : The password to be saved against the playlist
         *
         * @return string
         */

        public function set_password($playlist_id, $password)
        {

            $save_password_sql = "UPDATE playlists SET password = :p WHERE id = :pid";
            $prepare_password  = $this->db->prepare($save_password_sql);

            $prepare_password->bindParam(':p', $password, PDO::PARAM_STR);
            $prepare_password->bindParam(':pid', $playlist_id, PDO::PARAM_INT);

            try {

                $prepare_password->execute();
                echo 'success';
                exit;

            } catch (PDOException $e) {

                echo 'failed';
                exit;

            }

        }

        /**
         * This method will check if a playlist has a password set
         *
         * @param $unique_string: The unique string for the playlist to check
         *
         * @return boolean
         */

        public function has_password($unique_string)
        {

            $check_password = $this->db->query("SELECT COUNT(*) AS count FROM playlists WHERE unique_string = '$unique_string' AND password != ''");
            if ($check_password->fetchObject()->count == 1) {
                return true;
            } else {
                return false;
            }

        }

        /**
         * This method will get the name for a playlist
         *
         * @param $unique_string: The unique string for the playlist
         *
         * @return string
         */

        public function get_name($unique_string)
        {

            $unique_string = $this->sanitise($unique_string);
            $get_name      = $this->db->query("SELECT name FROM playlists WHERE unique_string = '$unique_string'");
            $name          = $get_name->fetchObject()->name;

            return $name;

        }

        /**
         * This method will get the videos for a playlist
         *
         * @param $unique_string: The unique string for the playlist to get the videos for
         *
         * @return array
         */

        public function get_videos($unique_string)
        {

            // Sanitize unique string
            $unique_string = $this->sanitise($unique_string);

            $get_videos    = $this->db->query("
                SELECT pv.* FROM playlists p, playlist_videos pv
                WHERE pv.playlist_id = p.id
                AND p.unique_string = '$unique_string'
                ORDER BY video_order ASC
            ");

            $all_videos = [];

            while ($videos = $get_videos->fetchObject()) {

                $all_videos[] = [
                    'id'    => $videos->video_id,
                    'start' => $videos->start,
                ];

            }

            return $all_videos;

        }

        /**
         * This method will get information like the title for a youtube video
         *
         * @param $video_id: The youtube video to get information for
         *
         * @return array
         */

        public function get_video_information($video_id)
        {

            $json_output = file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=snippet&id=' . $video_id . '&key=AIzaSyDZqUDzM5Iz5H4w7inMMz0Ght_hlxaheS4');
            $json        = json_decode($json_output, true);

            return [
                'title'     => $json['items'][0]['snippet']['title'],
                'thumbnail' => $json['items'][0]['snippet']['thumbnails']['default']['url'],
            ];

        }

        /**
         * This method will check the credentials submitted when a user tries to edit a playlist
         *
         * @param $unique_string: The playlist unique string to check the credentials for
         * @param $email        : The email to check
         * @param $password     : The password to check
         *
         * @return boolean
         */

        public function check_edit_credentials($unique_string, $email, $password)
        {

            $check_credentials = $this->db->query("SELECT COUNT(*) as count FROM playlists WHERE email = '$email' AND password = '$password' AND unique_string = '$unique_string'");
            if ($check_credentials->fetchObject()->count != 0) {

                return true;

            } else {

                return false;

            }

        }

        /**
         * This method will delete a video from a playlist
         *
         * @param $playlist_id: The playlist id for the playlist to delete the video from
         * @param $video_id   : The id for the video to delete from the playlist
         */

        public function delete_video($playlist_id, $video_id)
        {

            $delete_video_sql = "DELETE FROM playlist_videos WHERE playlist_id = :pid AND video_id = :vid";
            $prepare_delete   = $this->db->prepare($delete_video_sql);

            $prepare_delete->bindParam(':pid', $playlist_id, PDO::PARAM_INT);
            $prepare_delete->bindParam(':vid', $video_id, PDO::PARAM_STR);

            try {

                $prepare_delete->execute();
                echo 'success';
                exit;

            } catch (PDOException $e) {

                echo 'failed';
                exit;

            }

        }

        /**
         * This method will change the order of a video
         *
         * @param $playlist_id: The playlist which the video belongs to
         * @param video_id    : The id of the video to change the order for
         * @param $order      : The order to set for the video
         */

        public function save_video_order($playlist_id, $video_id, $order)
        {

            // Check if the order has changed or not
            $check_order = $this->db->query("
                SELECT COUNT(*) AS count
                FROM playlist_videos
                WHERE playlist_id = '$playlist_id'
                AND video_id = '$video_id'
                AND video_order = '$order'
            ");

            // If the video order has changed
            if ($check_order->fetchObject()->count == 0) {

                $update_order_sql     = "UPDATE playlist_videos SET video_order = :o WHERE video_id = :vid AND playlist_id = :pid";
                $prepare_update_order = $this->db->prepare($update_order_sql);

                $prepare_update_order->bindParam(':o', $order, PDO::PARAM_INT);
                $prepare_update_order->bindParam(':vid', $video_id, PDO::PARAM_STR);
                $prepare_update_order->bindParam(':pid', $playlist_id, PDO::PARAM_INT);

                try {

                    $prepare_update_order->execute();
                    echo 'success';
                    exit;

                } catch (PDOException $e) {

                    echo 'failed';
                    exit;

                }

            }

        }

    }
?>
