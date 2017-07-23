<?php require_once('inc/init.php'); ?>

<?php require_once('inc/header.php'); ?>

<div class="pt50">

    <div class="container">

        <div class="row">

            <div class="col s12">
                <h5 class="section-title main-text">Create a Playlist</h5>
            </div>

            <?php if ($errors->session_has_errors()) { ?>
                <div class="row" id="alert-box">

                    <div class="col s12">

                        <div class="col s12">

                            <div class="card red darken-1">

                                <div class="row">

                                    <div class="col s12 m10">
                                        <div class="card-content white-text">
                                            <?php foreach ($errors->get_errors() as $error) { ?>
                                                <p><?php echo $error; ?></p>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col s12 m2 right-align alert-close-icon-container">
                                        <i class="material-icons white-text pointer-cursor" id="alert-close">close</i>
                                    </div>

                                </div><!-- .row -->

                            </div><!-- .card -->

                        </div>

                    </div>

                </div><!-- #alert-box -->

                <?php $errors->reset(); ?>

            <?php } ?>

            <form action="<?php echo $config->site_url; ?>/create-playlist/" id="start-playlist" method="POST">

                <div class="input-field col s12 m5">
                    <input name="playlist_name" id="playlist_name" type="text" class="validate" autocomplete="off">
                    <label for="playlist_name" class="main-text-focus-important" data-error="Please enter a name for your playlist">Playlist Name</label>
                </div>

                <div class="input-field col s12 m5">
                    <input name="playlist_email" id="playlist_email" type="email" class="validate" autocomplete="off">
                    <label for="playlist_email" class="main-text-focus-important" data-error="Please enter your email address">Your Email</label>
                </div>

                <div class="col s12 m2 pt25i right-align">
                    <button class="btn waves-effect waves-light main-bg main-bg-hover main-bg-active" type="submit" name="playlist_go">Go
                        <i class="material-icons right">keyboard_arrow_right</i>
                    </button>
                </div>

            </form>

        </div>

    </div><!-- .container -->

</div><!-- .pt50 -->

<?php require_once('inc/footer.php'); ?>
