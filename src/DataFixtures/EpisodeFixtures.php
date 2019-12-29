<?php


namespace App\DataFixtures;


use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0 ; $i <= 50 ; $i++){
            $episode = new Episode();
            $episode->setTitle($faker->jobTitle);
            $episode->setNumber($faker->numberBetween(0,10));
            $episode->setSynopsis($faker->paragraph);
            $episode->setSeason($this->getReference('season_' . rand(0,10)));

            $slugify = new Slugify();
            $slug = $slugify->generate($episode->getTitle());
            $episode->setSlug($slug);

            $manager->persist($episode);
        }
        $manager->flush();
    }


    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}