<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 20; ++$i) {
            $tag = new Tag();
            $tag->setName($faker->word);
            $tag->setDescription(implode("\n\n", $faker->paragraphs(10)));
            $tag->setPriority($faker->numberBetween(1, 10));
            $tag->setMenu($faker->boolean);

            if (0 === $i % 2) {
                $tag->setParent($this->getReference('tag_'.($i - 1)));
            }

            $this->addReference('tag_'.$i, $tag);
            $manager->persist($tag);
        }

        $manager->flush();
    }
}
