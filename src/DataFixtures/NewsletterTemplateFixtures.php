<?php

namespace App\DataFixtures;

use App\Entity\NewsletterTemplate;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class NewsletterTemplateFixtures extends Fixture implements DependentFixtureInterface
{
    private const TEMPLATE_CONTENT = <<<EOT
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge">  
<body>
[[CONTENT]]
</body>
</html>
EOT;

    public function load(ObjectManager $manager): void
    {
        $newsletterTemplate = (new NewsletterTemplate())
            ->setTitle('Example of active temaplate')
            ->setContent(self::TEMPLATE_CONTENT)
            ->setIsActive(true)
            ->setCreatedBy($this->getReference(UserFixtures::class.'admin', User::class));

        $manager->persist($newsletterTemplate);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}
