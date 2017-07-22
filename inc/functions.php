<?php
    /**
     * This function will return the page title based on the last path of the url
     *
     * @param $url: This is the url of the current page
     */

    function get_page_title($url)
    {

        // TODO: This will need to be changed when the site is uploaded to the server
        $url_parts = explode('/', $url);

        // If the index before the last index of url parts is not personal-playlizt, select that index otherwise it's the homepage
        if ($url_parts[sizeof($url_parts) - 2] != 'personal-playlizt') {
            return ucwords(str_replace('-', ' ', $url_parts[sizeof($url_parts) - 2]));
        } else {
            return 'Home';
        }

    }
?>
