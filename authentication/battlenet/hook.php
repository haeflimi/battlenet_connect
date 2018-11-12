<?php defined('C5_EXECUTE') or die('Access Denied.');
$c = new Concrete\Package\BattlenetConnect\Authentication\Battlenet\Controller;?>

<div class="form-group">
    <a href="<?php echo \URL::to('/ccm/system/authentication/oauth2/battlenet/attempt_attach'); ?>" class="btn btn-primary btn-steam strip_button">
        <i class="fa fa-steam"></i>
        <?php echo t('Attach a %s account', t('battlenet')) ?>
    </a>
    <span class="help-block">
        <?=t('Connected Battle.net Account ID').': '.$code?>
    </span>
</div>

<style>
    .btn-steam {
        border-width: 0px;
        background: #171a21;
    }
    .btn-facebook .fa-steam {
        margin: 0 6px 0 3px;
    }
</style>
