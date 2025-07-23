<?php

namespace App\Twig\Runtime;

use App\Entity\PostThumb;
use Twig\Extension\RuntimeExtensionInterface;

class PostExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private PostThumb $postThumbs,
    )
    {

    }

    public function getScore(): int
    {
        $score = 0;
        foreach ($this->postThumbs as $thumb) {
            $score += $thumb->isType() ? 1 : -1;
        }
        return $score;
    }
}
