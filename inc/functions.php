<?php
    /**
     * This function will return the page title based on the last path of the url
     *
     * @param $url: This is the url of the current page
     */

    function get_page_title($url)
    {

        global $db;

        // TODO: This will need to be changed when the site is uploaded to the server
        $url_parts = explode('/', $url);

        // If the index before the last index of url parts is not personal-playlizt, select that index otherwise it's the homepage
        if ($url_parts[sizeof($url_parts) - 2] != 'personal-playlizt' && $url_parts[sizeof($url_parts) - 2] != 'p') {
            return ucwords(str_replace('-', ' ', $url_parts[sizeof($url_parts) - 2]));
        } else {
            if ($url_parts[sizeof($url_parts) - 2] == 'p') {

                $validate      = new validation();
                $unique_string = $validate->sanitise($_GET['id']);

                // Get playlist name
                $playlist_name = $db->query("SELECT name FROM playlists WHERE unique_string = '$unique_string'");
                return $playlist_name->fetchObject()->name;

            } else {
                return 'Home';
            }
        }

    }
?>
