<?php

namespace App\Command\App\Command;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[AsCommand(
    name: 'App\Command\SendTopCommentedNews',
    description: 'Add a short description for your command',
)]
class SendTopCommentedNewsCommand extends Command
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected MailerInterface        $mailer,
        protected Environment            $twig,
        protected ParameterBagInterface  $params

    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    /**
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $conn = $this->em->getConnection();
        $sql = "
            SELECT n.id, n.title, COUNT(c.id) as comment_count
            FROM news n
            JOIN comment c ON c.news_id = n.id
            GROUP BY n.id
            ORDER BY comment_count DESC
            LIMIT 10
        ";
        $newsList = $conn->executeQuery($sql)->fetchAllAssociative();

        // Render email content using Twig
        $htmlContent = $this->twig->render('email/top_commented_news.html.twig', [
            'newsList' => $newsList
        ]);

        // Send email
        $email = (new Email())
            ->from('noreply@example.com')
            ->to($this->params->get('news_recipient_email'))
            ->subject('Top 10 Most Commented News')
            ->html($htmlContent);

        $this->mailer->send($email);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
