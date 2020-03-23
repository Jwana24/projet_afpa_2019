<?php

namespace App\Security;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\Members;
use App\Entity\CommentsPost;

class CommentPostVoter extends Voter
{
    const MODIFPOSTCOMMENT = 'MODIFPOSTCOMMENT';

    // Determines if all the parameters are valid in the voter
    protected function supports($attribute, $subject)
    {
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

        /** @var Post $post */
        $comment = $subject;

        // Verify if the attribute(s) match to the constant
        switch ($attribute)
        {
            case self::MODIFPOSTCOMMENT:
                return $this->canModif($comment, $member);
        }

        throw new \LogicException('This code should not be reached!'); // Generate a Symfony's error
    }

    // The modifications can be effectued by the member bound to the comment or by an admin (defined by 'ROLE_ADMIN')
    private function canModif($comment, $member)
    {
        return $member === $comment->getIdMemberFK() || $member->getRoles()[0] === 'ROLE_ADMIN';
    }
}