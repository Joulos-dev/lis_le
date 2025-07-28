<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\CommentExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CommentExtension extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_number', [CommentExtensionRuntime::class, 'getNumber']),
        ];
    }
}
