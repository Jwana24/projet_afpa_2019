<?php

namespace App\Security;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\Members;
use App\Entity\CommentsPost;

class CommentPostVoter extends Voter
{
    const MODIFPOSTCOMMENT = 'MODIFPOSTCOMMENT';

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if(!in_array($attribute, [self::MODIFPOSTCOMMENT]))
        {
            return false;
        }

        // only vote on Comments objects inside this voter
        if(!$subject instanceof CommentsPost)
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
        $comment = $subject;

        switch ($attribute)
        {
            case self::MODIFPOSTCOMMENT:
                return $this->canModif($comment, $member);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canModif($comment, $member)
    {
        return $member === $comment->getIdMemberFK() || $member->getRoles()[0] === 'ROLE_ADMIN';
    }
}