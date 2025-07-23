<?php

namespace App\Twig\Runtime;

use App\Repository\CategoryRepository;
use Twig\Extension\RuntimeExtensionInterface;

class CategoryExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    )
    {

    }

    public function getCategories()
    {
        $categories = $this->categoryRepository->findAll();
        return $categories;
    }
}
