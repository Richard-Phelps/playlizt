<?php require_once('inc/init.php'); ?>

<?php require_once('inc/header.php'); ?>

<?php
    $playlists = new playlists();
    $videos    = $playlists->get_videos($_GET['id']);
?>

<div id="player"></div>

<?php
    $count = 0;

    foreach ($videos as $video) {

        $count++;

        if ($count == 1) {
            ?>
                <script type="text/javascript">
                    var videos = {
                        current: {
                            video_id: '<?php echo $video['id']; ?>',
                            start: <?php echo $video['start']; ?>,
                        },
                    };
                </script>
            <?php
        }

    }
?>

<?php require_once('inc/footer.php'); ?>
