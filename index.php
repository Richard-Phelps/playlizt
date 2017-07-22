<?php require_once('inc/init.php'); ?>

<?php require_once('inc/header.php'); ?>

<div class="pt50">

    <div class="container">

        <div class="row">

            <form action="<?php echo $config->site_url; ?>/create-playlist/" method="POST">

                <div class="input-field col m10">
                    <input name="playlist_name" id="playlist_name" type="text" class="validate invalid" autocomplete="off">
                    <label for="playlist_name" class="orange-text-focus-important" data-error="Please enter a name for your playlist">Name Your Playlist</label>
                </div>

                <div class="col m2 pt25i right-align">
                    <button class="btn waves-effect waves-light orange-bg orange-bg-hover" type="submit" name="playlist_go">Go
                        <i class="material-icons right">keyboard_arrow_right</i>
                    </button>
                </div>

            </form>

        </div>

    </div><!-- .container -->

</div><!-- .page-wrapper -->

<?php require_once('inc/footer.php'); ?>
