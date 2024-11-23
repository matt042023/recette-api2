<?php

namespace App\DataFixtures;

use App\Entity\Unit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UnitFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Liste d'unités communes pour des données réalistes
        $units = [
            ['singular' => 'gram', 'plural' => 'grams'],
            ['singular' => 'kilogram', 'plural' => 'kilograms'],
            ['singular' => 'liter', 'plural' => 'liters'],
            ['singular' => 'milliliter', 'plural' => 'milliliters'],
            ['singular' => 'cup', 'plural' => 'cups'],
            ['singular' => 'tablespoon', 'plural' => 'tablespoons'],
            ['singular' => 'teaspoon', 'plural' => 'teaspoons'],
            ['singular' => 'slice', 'plural' => 'slices'],
            ['singular' => 'piece', 'plural' => 'pieces'],
        ];

        foreach ($units as $index => $unitData) {
            $unit = new Unit();
            $unit->setSingular($unitData['singular']);
            $unit->setPlural($unitData['plural']);

            // Persister l'entité
            $manager->persist($unit);

            // Ajouter une référence pour d'autres entités
            $this->addReference('unit_'.$index, $unit);
        }

        //    // Ajout de quelques unités générées aléatoirement
        //    for ($i = 0; $i < 5; $i++) {
        //        $unit = new Unit();
        //        $unit->setSingular($faker->word());
        //        $unit->setPlural($faker->word() . 's'); // Génère un pluriel arbitraire

        //        $manager->persist($unit);
        //    }

        $manager->flush();
    }
}
