<?php

namespace App\Twig\Runtime;

use App\Entity\Message;
use App\Entity\User;
use Doctrine\ORM\Query\AST\LikeExpression;
use Twig\Extension\RuntimeExtensionInterface;

class PostExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
    )
    {

    }

    public function getScore(Message $message): int
    {
        $score = 0;
        if ($message->getReactions()->count() === 0) return $score;

        foreach ($message->getReactions() as $reaction) {
            if ($reaction->isType() === true) {
                $score++;
            } else {
                $score--;
            }
        }

        return $score;
    }

    public function getUserLike(User $user, Message $message): int
    {
        $user->getReaction();

    }


}
