<?php
    require_once('inc/init.php');

    if (isset($_POST['set_playlist_password']) && $_POST['set_playlist_password'] == 'true') {

        $validation = new validation();
        $post_data  = $validation->sanitise($_POST);
        extract($post_data);

        if (isset($playlist_id) && !empty($playlist_id) && isset($playlist_password)) {

            

        } else {

            echo 'You can\'t access this page like that!';
            header('Location: ' . $config->site_url);
            exit;

        }

    } else {

        echo 'You can\'t access this page like that!';
        header('Location: ' . $config->site_url);
        exit;

    }
?>
