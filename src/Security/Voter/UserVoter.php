<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    const DELETE = 'delete';
    const EDIT = 'edit';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [
            self::DELETE,
            self::EDIT
        ])
            && $subject instanceof User;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($user);
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case self::DELETE:
                return $this->canDelete($user);
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }

    public function canEdit(User $user): bool
    {
        return $user->getId() === $user
            || $this->security->isGranted('ROLE_ADMIN');
    }

    public function canDelete(User $user): bool
    {
        return $user->getId()
            && $this->canEdit($user);
    }
}