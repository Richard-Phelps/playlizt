<?php require_once('inc/init.php'); ?>

<?php require_once('inc/header.php'); ?>

<?php
    $playlists    = new playlists();
    $videos       = $playlists->get_videos($_GET['id']);
    $videos_count = count($videos);
?>

<script type="text/javascript">

    var videos = [];
    videos['count'] = <?php echo $videos_count; ?>;

    <?php
        $count = 0;

        foreach ($videos as $video) {

            $count++;

            ?>
                videos[<?php echo $count; ?>] = {
                    video_id: '<?php echo $video['id']; ?>',
                    start   : <?php echo $video['start']; ?>,
                    loop    : 0,
                };
            <?php

        }
    ?>

</script>

<div class="pt50">

    <div class="container playlist-container pb50i">

        <div class="row mb0">

            <div class="col s12 pb50i">
                <h5 class="section-title main-text">Playlist: <?php echo $playlists->get_name($_GET['id']); ?></h5>
            </div>

            <div class="col s12 p0i">

                <div class="col m8">

                    <div id="player"></div>

                </div>

                <div class="col m4">

                    <div class="col s12 p0">
                        <h5 class="section-title main-text mt0">Playlist Options</h5>
                    </div>

                    <div class="col s12 p0 pt15i">
                        <i class="material-icons grey-text main-text-hover-important playlist-options-icon pointer-cursor" id="repeat-playlist" title="Repeat Playlist">repeat</i>
                        <i class="material-icons grey-text main-text-hover-important playlist-options-icon pointer-cursor ml25" id="loop-current" title="Loop Current Video">loop</i>
                        <i class="material-icons grey-text main-text-hover-important playlist-options-icon pointer-cursor ml25" id="replay" title="Replay PLaylist">replay</i>
                        <i class="material-icons grey-text main-text-hover-important playlist-options-icon pointer-cursor ml25" id="replay" title="Replay PLaylist">skip_next</i>
                    </div>

                </div>

            </div>

            <?php
                $playlist_count = 1;

                foreach ($videos as $video) {

                    $video_information = $playlists->get_video_information($video['id']);

                    ?>

                        <div class="col s12 p0i pt15i">

                            <div class="col m8">

                                <div class="song-container smooth-box-shadow white-bg mt0i" vid-count="<?php echo $playlist_count; ?>">
                                    <p class="margin0 main-text">
                                        <img src="<?php echo $video_information['thumbnail']; ?>" alt="<?php echo $video_information['title']; ?>">
                                        <span class="main-text-important"><?php echo $video_information['title']; ?></span>
                                    </p>
                                </div>

                            </div>

                            <div class="col m4 song-row-options">
                                <i class="material-icons grey-text main-text-hover-important playlist-options-icon pointer-cursor play-video" vid-count="<?php echo $playlist_count; ?>" title="Play Video">play_arrow</i>
                            </div>

                        </div>

                    <?php

                    $playlist_count++;

                }
            ?>

        </div><!-- .row -->

    </div><!-- .container -->

</div><!-- .pt50 -->

<?php require_once('inc/footer.php'); ?>
