<?php

namespace Bundle\Kris\FacebookBundle\Security\Provider;

use Symfony\Component\Security\User\User;
use Symfony\Component\Security\User\UserProviderInterface;
use Symfony\Component\Security\Exception\UsernameNotFoundException;

class FacebookProvider implements UserProviderInterface
{
    protected $facebook;

    public function __construct(\Facebook $facebook)
    {
        $this->facebook = $facebook;
    }

    public function loadUserByUsername($username)
    {
        if (!$uid = $this->getFacebookSession()) {
            throw new UsernameNotFoundException('The user cannot be authenticated');
        }

        return new User($uid, uniqid(), array('ROLE_USER'), true, true, true, true);
    }

    protected function getFacebookSession()
    {
        try {
            // Find out if a session already exist. If so, check that it is still valid.
            if ($this->facebook->getSession()) {
                // Make sure that session is still valid
                return $this->facebook->getUser();
            }
        } catch (\FacebookApiException $e) {
        }

        return false;
    }
}
