<?php

declare(strict_types=1);

namespace Palmyr\SymfonyAws\Command;

use Aws\Sts\StsClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetCallerIdentityCommand extends Command
{

    protected StsClient $stsClient;

    public function __construct(StsClient $stsClient)
    {
        $this->stsClient = $stsClient;
        parent::__construct("sts:get_caller_identity");
    }

    protected function configure()
    {
        parent::configure();
        $this->setDescription("Get account details from the current users session.");
    }
    protected function runCommand(InputInterface $input, SymfonyStyle $io): int
    {

        $result = $this->stsClient->getCallerIdentity();

        $headers = [
            "Account",
            "Arn",
            "UserId",
        ];

        $row = [
            $result->get("Account"),
            $result->get("Arn"),
            $result->get("UserId")
        ];

        $io->table($headers, [$row]);

        return self::SUCCESS;
    }
}
