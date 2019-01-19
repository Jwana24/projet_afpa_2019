<?php

namespace App\Security;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\Members;
use App\Entity\Posts;

class PostVoter extends Voter
{
    const MODIFPOST = 'MODIFPOST';

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if(!in_array($attribute, [self::MODIFPOST]))
        {
            return false;
        }

        // only vote on Comments objects inside this voter
        if(!$subject instanceof Posts)
        {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $member = $token->getUser();

        if(!$member instanceof Members)
        {
            // the member must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Post object, thanks to supports
        /** @var Post $post */
        $post = $subject;

        switch ($attribute)
        {
            case self::MODIFPOST:
                return $this->canModif($post, $member);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canModif($post, $member)
    {
        return $member === $post->getIdMemberFK() || $member->getRoles()[0] === 'ROLE_ADMIN';
    }
}