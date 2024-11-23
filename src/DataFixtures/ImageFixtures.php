<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 30; ++$i) {
            $image = new Image();

            $image->setName($faker->word());
            $image->setDescription($faker->paragraph(3));
            $image->setPriority($faker->numberBetween(1, 10));
            $image->setPath($faker->imageUrl());
            $image->setSize($faker->numberBetween(5000, 500000)); // Size in bytes

            // Assigning Step or Recipe
            if ($faker->boolean(50)) {
                $step = $this->getReference('step_'.$faker->numberBetween(0, 19));
                $image->setStep($step);
            } else {
                $recipe = $this->getReference('recipe_'.$faker->numberBetween(0, 19));
                $image->setRecipe($recipe);
            }

            // Setting timestamps
            $image->setCreatedAt(new \DateTimeImmutable());
            $image->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($image);

            $this->addReference('image_'.$i, $image);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            StepFixtures::class,
            AppFixtures::class,
        ];
    }
}
