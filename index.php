<?php require_once('inc/init.php'); ?>

<?php require_once('inc/header.php'); ?>

<?php $errors->add_error('test'); ?>

<div class="pt50">

    <div class="container">

        <div class="row">

            <div class="col s12">
                <h5 class="section-title orange-text-important">Create a Playlist</h5>
            </div>

            <form action="<?php echo $config->site_url; ?>/create-playlist/" id="start-playlist" method="POST">

                <div class="input-field col s12 m5">
                    <input name="playlist_name" id="playlist_name" type="text" class="validate" autocomplete="off">
                    <label for="playlist_name" class="orange-text-focus-important" data-error="Please enter a name for your playlist">Playlist Name</label>
                </div>

                <div class="input-field col s12 m5">
                    <input name="playlist_email" id="playlist_email" type="email" class="validate" autocomplete="off">
                    <label for="playlist_email" class="orange-text-focus-important" data-error="Please enter your email address">Your Email</label>
                </div>

                <div class="col s12 m2 pt25i right-align">
                    <button class="btn waves-effect waves-light orange-bg orange-bg-hover" type="submit" name="playlist_go">Go
                        <i class="material-icons right">keyboard_arrow_right</i>
                    </button>
                </div>

            </form>

        </div>

    </div><!-- .container -->

</div><!-- .page-wrapper -->

<?php require_once('inc/footer.php'); ?>
