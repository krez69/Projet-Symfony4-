<?php


namespace App\DataFixtures;


use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = [
        'Action',
        'Aventure',
        'Horreur',
        'Fantastique',
        'Animation',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);

            //Crée la référence correspondant à chaque instance de Category
            //Cela se traduit par la création de cette référence  après l'appel à la méthode persist()
            //$key (issue du foreach) permet d'obtenir un identifiant unique pour chaque catégorie, sous la forme 'categorie_0', 'categorie_1', etc.
            $this->addReference('categorie_' . $key, $category);
        }

        $manager->flush();
    }
}