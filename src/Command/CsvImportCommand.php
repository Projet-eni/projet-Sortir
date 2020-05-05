<?php

// /src/Command/CsvImportCommand.php

namespace App\Command;

use App\Entity\Participant;
use App\Entity\Site;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
/**
 * Class CsvImportCommand
 * @package App\ConsoleCommand
 */
class CsvImportCommand extends Command
{

    private $em;

    /**
     * CsvImportCommand constructor.
     *
     * @param EntityManagerInterface $em
     *
     * @param LoggerInterface $logger
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    /**
     * Configure
     * @throws InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('csv:import')
            ->setDescription('Imports the test CSV data file')

        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Attempting import of Feed...');

        $reader = Reader::createFromPath('C:\wamp64\www\projet-Sortir\src\Data\participant.csv');

        $results = $reader->fetchAssoc();
        $io->progressStart(iterator_count($results));

        foreach ($results as $row) {

            //check DB if participant exist
            $participant = $this->em->getRepository(Participant::class)
                ->findOneBy([
                   'pseudo' => $row['pseudo']
                ]);

            if($participant === null) {
                // create new participant if not
                $participant = (new Participant())
                    ->setNom($row['nom'])
                    ->setMotDePasse($row['mot_de_passe'])
                    ->setPrenom($row['prenom'])
                    ->setPseudo($row['pseudo'])
                    ->setTelephone($row['telephone'])
                    ->setMail($row['mail'])
                    ->setRole(['ROLE_USER'])
                ;

                $this->em->persist($participant);

                $this->em->flush();
            }

            // check DB if site exist
            $site = $this->em->getRepository('App:Site')
                ->findOneBy([
                    'nom' => $row['site']
                ]);

            if($site === null) {
                // create new site if not
                $site = (new Site())
                    ->setNom($row['site'])
                ;

                $this->em->persist($site);

                $this->em->flush();
            }

            $participant->setSite($site);

            $io->progressAdvance();
        }

        $this->em->flush();

        $io->progressFinish();

        $io->success('Success!');
    }
}