<?php
if (isset($error)) {
    ?>
    <div class="alert alert-danger"><?php echo $error ?></div>
<?php

}
if (isset($message)) {
    ?>
    <div class="alert alert-success"><?php echo $message ?></div>
<?php

}

$user = new User();

if ($user->isLoggedIn()) {
    ?>
    <div class="form-group">
        <span>
            <?php echo t('Attach a %s account', t('battlenet')) ?>
        </span>
        <hr>
    </div>
    <div class="form-group">
        <a href="<?php echo \URL::to('/ccm/system/authentication/oauth2/battlenet/attempt_attach');
    ?>" class="btn btn-primary btn-facebook btn-block">
            <i class="fa fa-facebook"></i>
            <?php echo t('Attach a %s account', t('battlenet')) ?>
        </a>
    </div>
<?php

} else {
    ?>
    <div class="form-group">
        <span>
            <?php echo t('Sign in with %s', t('battlenet')) ?>
        </span>
        <hr>
    </div>
    <div class="form-group">
        <a href="<?php echo \URL::to('/ccm/system/authentication/oauth2/battlenet/attempt_auth');
    ?>" class="btn btn-primary btn-facebook btn-block">
            <i class="fa fa-facebook"></i>
            <?php echo t('Log in with %s', 'battlenet') ?>
        </a>
    </div>
<?php

}
?>
<style>
    .ccm-ui .btn-steam {
        border-width: 0px;
        background: #171a21;
    }
    .btn-steam .fa-steam {
        margin: 0 6px 0 3px;
    }
</style>
