<?php

namespace App\DataFixtures;

use App\Entity\Source;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SourceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 10; ++$i) {
            $source = new Source();

            // Génération d'un nom aléatoire
            $source->setName($faker->sentence(3)); // Un titre court de 3 mots

            // Génération d'une description de trois paragraphes
            $source->setDescription(implode("\n\n", $faker->paragraphs(3)));

            // Génération d'une taille aléatoire
            $source->setSize($faker->numberBetween(10, 500)); // Taille arbitraire

            // Génération d'une URL aléatoire ou null
            if ($faker->boolean(80)) { // 80% de chance d'avoir une URL
                $source->setUrl($faker->url);
            } else {
                $source->setUrl(null);
            }

            // Définir les timestamps pour la source
            $source->setCreatedAt(new \DateTimeImmutable());
            $source->setUpdatedAt(new \DateTimeImmutable());

            // Persister l'entité
            $manager->persist($source);

            // Optionnel : Ajouter une référence pour d'autres relations
            $this->addReference('source_'.$i, $source);
        }

        $manager->flush();
    }
}
