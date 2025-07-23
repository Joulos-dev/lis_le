<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\PostExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class PostExtension extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_score', [PostExtensionRuntime::class, 'getScore']),
        ];
    }
}
