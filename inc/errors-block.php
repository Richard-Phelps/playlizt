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
