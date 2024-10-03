<?php

namespace App\DataFixtures;

use App\Entity\CoverLetter;
use App\Entity\JobOffer;
use App\Entity\LinkedInMessage;
use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Create admin user
        $admin = new User();
        $admin
            ->setEmail('admin@gmail.com')
            ->setFirstname('admin')
            ->setLastName('admin')
            ->setPassword($this->hasher->hashPassword($admin, 'admin'))
            ->setRoles(['ROLE_ADMIN']); // Corrected from setRole to setRoles and made it an array
        $manager->persist($admin);
        $this->addReference('user_admin', $admin);

        // Create regular users
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user
                ->setEmail($faker->email)
                ->setFirstname($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPassword($this->hasher->hashPassword($user, 'password'))
                ->setRoles(['ROLE_USER']);
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        // Create job offers
        for ($i = 0; $i < 20; $i++) {
            $jobOffer = new JobOffer();
            $jobOffer
                ->setCompany($faker->company)
                ->setTitle($faker->jobTitle)
                ->setLink($faker->url)
                ->setLocation($faker->city)
                ->setSalary($faker->numberBetween(30000, 100000) . '€ - ' . $faker->numberBetween(100001, 150000) . '€')
                ->setContactPerson($faker->name)
                ->setContactEmail($faker->email)
                ->setStatus($faker->randomElement(['À postuler', 'En attente', 'Entretien', 'Refusé', 'Accepté']))
                ->setApplicationDate($faker->dateTimeThisYear())
                ->setAppUser($this->getReference('user_' . $faker->numberBetween(0, 9)));
            $manager->persist($jobOffer);
        }

        // Create cover letters
        for ($i = 0; $i < 15; $i++) {
            $coverLetter = new CoverLetter();
            $coverLetter
                ->setContent($faker->paragraphs(3, true))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setJobOffer($jobOffer)
                ->setAppUser($this->getReference('user_' . $faker->numberBetween(0, 9)));
            $manager->persist($coverLetter);
        }

        // Create LinkedIn messages
        for ($i = 0; $i < 25; $i++) {
            $linkedInMessage = new LinkedInMessage();
            $linkedInMessage
                ->setContent($faker->paragraph)
                ->setJobOffer($jobOffer)
                ->setAppUser($this->getReference('user_' . $faker->numberBetween(0, 9)));
            $manager->persist($linkedInMessage);
        }

        $manager->flush();
    }
}
