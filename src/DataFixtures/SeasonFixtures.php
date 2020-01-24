<?php


namespace App\DataFixtures;


use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i <= 30; $i++) {
            $season = new Season();
            $season->setYear($faker->year);
            $season->setDescription($faker->paragraph);
            $season->setProgram($this->getReference('program_' . rand(0, 5)));
            $manager->persist($season);
            $this->addReference('season_' . $i, $season);

        }
        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

}