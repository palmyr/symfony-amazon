<?php

declare(strict_types=1);

namespace Palmyr\SymfonyAws\Command;

use Aws\Sts\StsClient;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetCallerIdentityCommand extends AbstractAwsCommand
{

    protected StsClient $stsClient;

    public function __construct(
        ContainerInterface $container
    )
    {
        parent::__construct($container, "sts:get_caller_identity");
    }

    protected function configure()
    {
        parent::configure();
        $this->setDescription("Get account details from the current users session.");
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $io = new SymfonyStyle($input, $output);

        $result = $this->getStsClient()->getCallerIdentity();

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

    public static function getSubscribedServices(): array
    {
        return [
            StsClient::class => StsClient::class,
        ];
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getStsClient(): StsClient
    {
        return $this->container->get(StsClient::class);
    }
}
