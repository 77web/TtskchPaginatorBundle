<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DatabaseSeedCommand extends Command
{
    protected static $defaultName = 'app:database:seed';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Initialize database with test data')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $users = require __DIR__.'/../../fixtures/users.php';
        $posts = require __DIR__.'/../../fixtures/posts.php';

        foreach ($users as $user) {
            $userEntity = (new User())
                ->setName($user['name'])
                ->setEmail($user['email']);

            $this->em->persist($userEntity);
        }

        $this->em->flush();

        $userRepository = $this->em->getRepository(User::class);

        foreach ($posts as $post) {
            $postEntity = (new Post())
                ->setUser($userRepository->find($post['userId']))
                ->setSubject($post['subject'])
                ->setBody($post['body'])
                ->setDate(new \DateTime($post['date']))
            ;

            $this->em->persist($postEntity);
        }

        $this->em->flush();

        $io->success('Done.');

        return 0;
    }
}
