<?php
namespace Concrete\Package\BattlenetConnect;

use Package;
use Concrete\Core\Authentication\AuthenticationType;
use Core;

class Controller extends Package
{
    protected $pkgHandle = 'battlenet_connect';
    protected $appVersionRequired = '5.8.1';
    protected $pkgVersion = '0.1';
    protected $pkgAutoloaderRegistries = array(
        'src/Battlenet/Factory/' => 'Concrete\Package\BattlenetConnect\Battlenet\Factory',
    );

    public function getPackageName()
    {
        return t('Battle.net Authentication');
    }

    public function getPackageDescription()
    {
        return t('Adds a Authentication Service Provider for Blizzard\'s Battle.net Gaming Platform');
    }

    public function on_start()
    {

    }

    public function install()
    {
        $pkg = parent::install();
        $type = AuthenticationType::add('battlenet', 'Battle.net', null, $pkg);
        $type->disable();
    }

    public function upgrade()
    {
        parent::upgrade();
    }

    public function uninstall(){
        $pkg = parent::uninstall();
        $type = AuthenticationType::getByHandle('battlenet');
        $type->delete();
    }
}