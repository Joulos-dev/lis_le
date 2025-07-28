<?php

namespace App\Twig\Runtime;

use App\Entity\Message;
use Twig\Extension\RuntimeExtensionInterface;

class CommentExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(

    )
    {

    }

    public function getNumber(Message $message): int
    {
        return count($message->getChildren());
    }
}
