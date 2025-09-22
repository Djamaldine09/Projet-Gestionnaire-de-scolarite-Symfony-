<?php
// src/Command/ListUsersCommand.php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListUsersCommand extends Command
{
    protected static $defaultName = 'app:list-users';
    
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setDescription('List all users in the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $users = $this->entityManager->getRepository(User::class)->findAll();

        if (empty($users)) {
            $io->success('Aucun utilisateur trouvé dans la base de données.');
            return Command::SUCCESS;
        }

        $io->title('Liste des Utilisateurs');
        
        foreach ($users as $user) {
            $io->writeln(sprintf(
                '- ID: %d | Email: %s | Rôles: %s',
                $user->getId(),
                $user->getEmail(),
                implode(', ', $user->getRoles())
            ));
        }

        return Command::SUCCESS;
    }
}