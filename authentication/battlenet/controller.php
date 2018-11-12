<?php

namespace Concrete\Package\BattlenetConnect\Authentication\Battlenet;

defined('C5_EXECUTE') or die('Access Denied');

use Concrete\Core\Authentication\Type\OAuth\OAuth2\GenericOauth2TypeController;
use Concrete\Package\BattlenetConnect\Battlenet\Factory\BattlenetServiceFactory;
use User;

class Controller extends GenericOauth2TypeController
{
    protected $openid;
    protected $openid_identity = 'https://eu.battle.net/oauth/authorize';
    protected $authenticationTypeImage = 'https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_01.png';
    protected $urlResolver;

    public function registrationGroupID()
    {
        return \Config::get('auth.battlenet.registration.group');
    }

    public function supportsRegistration()
    {
        return \Config::get('auth.battlenet.registration.enabled', false);
    }

    public function getAuthenticationTypeIconHTML()
    {
        return '<i class="fa fa-trophy"></i>';
    }

    public function getAuthenticationTypeImage()
    {
        return $this->authenticationTypeImage;
    }

    public function getHandle()
    {
        return 'battlenet';
    }

    public function view()
    {

    }

    protected function attemptAuthentication()
    {
        $token = $this->getToken();
        $user_id = $this->getBoundUserID($token->getAccessToken());

        if ($user_id && $user_id > 0) {
            $user = \User::loginByUserID($user_id);
            if ($user && !$user->isError()) {
                return $user;
            }
        }

        return null;
    }

    public function handle_attach_callback()
    {
        $user = new User();
        if (!$user->isLoggedIn()) {
            id(new RedirectResponse(\URL::to('')))->send();
            exit;
        }

        try {
            $code = \Request::getInstance()->get('code');
            $token = $this->getService()->requestAccessToken($code);
        } catch (TokenResponseException $e) {
            $this->showError(t('Failed authentication: %s', $e->getMessage()));
            exit;
        }
        if ($token) {
            if ($this->bindUser($user, $token->getAccessToken())) {
                $this->showSuccess(t('Successfully attached.'));
                exit;
            }
        }
        $this->showError(t('Unable to attach user.'));
        exit;
    }

    public function getService()
    {
        if (!$this->service) {
            $factory = $this->app->make(BattlenetServiceFactory::class);
            $this->service = $factory->createService();
        }

        return $this->service;
    }


    public function saveAuthenticationType($args)
    {
        \Config::save('auth.battlenet.client_id', $args['client_id']);
        \Config::save('auth.battlenet.client_secret', $args['client_secret']);
        \Config::save('auth.battlenet.registration.enabled', (bool) $args['registration_enabled']);
        \Config::save('auth.battlenet.registration.group', intval($args['registration_group'], 10));
    }

    public function edit()
    {
        $this->set('form', \Loader::helper('form'));
        $this->set('client_id', \Config::get('auth.battlenet.client_id'));
        $this->set('client_secret', \Config::get('auth.battlenet.client_secret'));

        $list = new \GroupList();
        $list->includeAllGroups();
        $this->set('groups', $list->getResults());
    }
}
