<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Command;

use App\Domain\Model\Usuario;
use App\Infrastructure\Repository\UsuarioRepositoryImpl;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;
use function Symfony\Component\String\u;


class AddUserCommand extends Command
{
    // to make your command lazily loaded, configure the $defaultName static property,
    // so it will be instantiated only when the command is actually called.
    protected static $defaultName = 'app:add-usuario';

    /**
     * @var SymfonyStyle
     */
    private $io;

    private $entityManager;
    private $users;

    public function __construct(EntityManagerInterface $em, UsuarioRepositoryImpl $users)
    {
        parent::__construct();

        $this->entityManager = $em;
        $this->users = $users;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Criando um usuario')
//            ->setHelp($this->getCommandHelp())
            ->addArgument('nome', InputArgument::OPTIONAL, 'Digite o nome')
            ->addArgument('password', InputArgument::OPTIONAL, 'Digite a senha')
            ->addArgument('email', InputArgument::OPTIONAL, 'Digite o email')
            ->addArgument('admin', InputArgument::OPTIONAL, 'Seu usuário será administrador do sistema Y/N')
        ;
    }

    /**
     * This optional method is the first one executed for a command after configure()
     * and is useful to initialize properties based on the input arguments and options.
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        // SymfonyStyle is an optional feature that Symfony provides so you can
        // apply a consistent look to the commands of your application.
        // See https://symfony.com/doc/current/console/style.html
        $this->io = new SymfonyStyle($input, $output);
    }

    /**
     * This method is executed after initialize() and before execute(). Its purpose
     * is to check if some of the options/arguments are missing and interactively
     * ask the user for those values.
     *
     * This method is completely optional. If you are developing an internal console
     * command, you probably should not implement this method because it requires
     * quite a lot of work. However, if the command is meant to be used by external
     * users, this method is a nice way to fall back and prevent errors.
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (null !== $input->getArgument('nome') && null !== $input->getArgument('password') && null !== $input->getArgument('email')) {
            return;
        }

        $this->io->title('Add Usuario Command Wizard');

        $nome = $input->getArgument('nome');
        if (null !== $nome) {
            $this->io->text(' > <info>Username</info>: '.$nome);
        } else {
            $nome = $this->io->ask('nome');
            $input->setArgument('nome', $nome);
        }

        $password = $input->getArgument('password');
        if (null !== $password) {
            $this->io->text(' > <info>Password</info>: '.$password);
        }else {
            $password = $this->io->ask('Digite sua senha');
            $input->setArgument('password', $password);
        }

        $email = $input->getArgument('email');
        if (null !== $email) {
            $this->io->text(' > <info>Email</info>: '.$email);
        }else {
            $email = $this->io->ask('Email');
            $input->setArgument('email', $email);
        }

        $admin = $this->io->ask('admin');
        $input->setArgument('admin', $admin);
    }

    /**
     * This method is executed after interact() and initialize(). It usually
     * contains the logic to execute to complete this command task.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('add-user-command');

        $username = $input->getArgument('nome');
        $password = $input->getArgument('password');
        $email = $input->getArgument('email');
        $admin = $input->getArgument('admin');

        $user = new Usuario();
        $user->setNome($username);
        $user->setEmail($email);
        $user->setRoles([$admin == 'y' ? 'ROLE_ADMIN' : 'ROLE_USER']);
        $user->setPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $event = $stopwatch->stop('add-user-command');
        if ($output->isVerbose()) {
            $this->io->comment(sprintf('New user database id: %d / Elapsed time: %.2f ms / Consumed memory: %.2f MB', $user->getId(), $event->getDuration(), $event->getMemory() / (1024 ** 2)));
        }

        return 0;
    }

    /**
     * The command help is usually included in the configure() method, but when
     * it's too long, it's better to define a separate method to maintain the
     * code readability.
     */
    private function getCommandHelp(): string
    {
        return <<<'HELP'
            The <info>%command.name%</info> command creates new users and saves them in the database:
            
              <info>php %command.full_name%</info> <comment>username password email</comment>
            
            By default the command creates regular users. To create administrator users,
            add the <comment>--admin</comment> option:
            
              <info>php %command.full_name%</info> username password email <comment>--admin</comment>
            
            If you omit any of the three required arguments, the command will ask you to
            provide the missing values:
            
              # command will ask you for the email
              <info>php %command.full_name%</info> <comment>username password</comment>
            
              # command will ask you for the email and password
              <info>php %command.full_name%</info> <comment>username</comment>
            
              # command will ask you for all arguments
              <info>php %command.full_name%</info>
            
            HELP;
    }
}
