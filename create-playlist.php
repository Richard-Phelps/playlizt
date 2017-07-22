<?php require_once('inc/init.php'); ?>

<?php require_once('inc/header.php'); ?>

<?php
    $validation  = new validation();
    $posted_data = $validation->sanitise($_POST);
    extract($posted_data);
?>

<?php require_once('inc/footer.php'); ?>
