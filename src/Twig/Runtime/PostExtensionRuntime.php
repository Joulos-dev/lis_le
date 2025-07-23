<?php

namespace App\Twig\Runtime;

use App\Entity\Post;
use App\Entity\PostThumb;
use Twig\Extension\RuntimeExtensionInterface;

class PostExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
    )
    {

    }

    public function getScore(Post $post): int
    {
        $score = 0;
        foreach ($post->getPostThumbs() as $postThumb){
            if($postThumb->isType() === true){
                $score = $score +1;
            } else {
                $score = $score - 1;
            }
        }
        //        foreach ($this->postThumb as $thumb) {
//            $score += $thumb->isType() ? 1 : -1;
//        }
        return $score;
    }
}
