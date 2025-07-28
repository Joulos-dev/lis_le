<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\MessageFactory;
use App\Factory\ReactionFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        UserFactory::createMany(50);

        CategoryFactory::createOne(['name'=> 'Politique']);
        CategoryFactory::createOne(['name'=> 'Culturel']);
        CategoryFactory::createOne(['name'=> 'Technologique']);
        CategoryFactory::createOne(['name'=> 'Sport']);
        CategoryFactory::createOne(['name'=> 'Jeux-Vidéo']);
        CategoryFactory::createOne(['name'=> 'Film/Séries']);
//        MessageFactory::createMany(100);

//        // création des 20 commentaires parents
//        $rootComments = MessageFactory::createMany(20);
//
//        // Fonction récursive pour générer des enfants
//        $generateChildren = function ($parents, $level = 1, $maxLevel = 3) use (&$generateChildren) {
//            if ($level > $maxLevel) {
//                return;
//            }
//
//            foreach ($parents as $parent) {
//                // Pour chaque parent, on génère un nombre aléatoire d'enfants (0 à 3)
//                $children = MessageFactory::createMany(rand(0, 3), function() use ($parent) {
//                    return [
//                        'parent' => $parent,
//                    ];
//                });
//
//                // Récursion : chaque enfant peut avoir ses propres enfants
//                $generateChildren($children, $level + 1, $maxLevel);
//            }
//        };
//
//        // Démarre la génération récursive
//        $generateChildren($rootComments);
//
//        ReactionFactory::createMany(100);
    }
}
