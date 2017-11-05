<?php

namespace Cinevi\AdminBundle\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Cinevi\SecurityBundle\Entity\User;

abstract class BaseVoter extends Voter
{
    protected $className;

    const VIEW = 'view';
    const CREATE = 'create';
    const EDIT = 'edit';
    const DELETE = 'delete';

    protected function supports($attribute, $obj)
    {
        $checkArray = in_array($attribute, array(
            self::VIEW,
            self::CREATE,
            self::EDIT,
            self::DELETE,
        ));

        if (!$checkArray) {
            return false;
        }

        if (!$obj instanceof $this->className) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $obj, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        if ($this->decisionManager->decide($token, array('ROLE_SUPER_ADMIN'))) {
            return true;
        }

        switch ($attribute) {
            case self::VIEW:
                return $this->view($obj, $user, $token);
            case self::CREATE:
                return $this->create($obj, $user, $token);
            case self::EDIT:
                return $this->edit($obj, $user, $token);
            case self::DELETE:
                return $this->delete($obj, $user, $token);
            default:
                return false;
        }
    }

    protected function view($obj, $user, TokenInterface $token)
    {
        return false;
    }

    protected function create($obj, $user, TokenInterface $token)
    {
        return false;
    }

    protected function edit($obj, $user, TokenInterface $token)
    {
        return false;
    }

    protected function delete($obj, $user, TokenInterface $token)
    {
        return false;
    }
}
