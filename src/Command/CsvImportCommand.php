<?php

// /src/Command/CsvImportCommand.php

namespace App\Command;

use App\Entity\Participant;
use App\Entity\Site;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CsvImportCommand
 * @package App\ConsoleCommand
 */
class CsvImportCommand extends Command
{

    private $em;

    private $validator;

    /**
     * CsvImportCommand constructor.
     *
     * @param EntityManagerInterface $em
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        parent::__construct();
        $this->em = $em;
        $this->validator = $validator;
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
            ->addArgument('path', InputArgument::REQUIRED, 'Quel est le nom du fichier à importer ?')

        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Attempting import of Feed...');

        $csvFilePath = 'C:\wamp64\www\projet-Sortir\src\Data\\'.$input->getArgument('path');
        $reader = Reader::createFromPath($csvFilePath);

        $results = $reader->fetchAssoc();
        $io->progressStart(iterator_count($results));

        $counter = 1;
        foreach ($results as $row) {

            $counter++;

            //check DB if participant exist
            $participantPseudo = $this->em->getRepository(Participant::class)
                ->findOneBy([
                   'pseudo' => $row['pseudo']
                ]);

            $participantMail = $this->em->getRepository(Participant::class)
                ->findOneBy([
                    'mail' => $row['mail']
                ]);

            if($participantPseudo === null && $participantMail === null) {
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

                $errors = $this->validator->validate($participant);
                if(count($errors) > 0){
                    $output->write('Les informations à la ligne '.$counter.' que vous essayez d\'importer ne sont pas conformes ' );
                    return 0;
                }

            }
            else{
                $output->write('Un utilisateur avec ce pseudo ou ce mail existe déjà. Ligne : '.$counter);
                return 0;
            }


            $this->em->persist($participant);
            $this->em->flush();

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

        return 0;
    }
}