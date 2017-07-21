<?php
    require_once('inc/init.php');
    $prep = $db->prepare("INSERT INTO playlists WHERE (user_associated, user, created) VALUES('0', '0', NOW()");
    $prep->execute();
?>
