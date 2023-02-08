<?php declare(strict_types=1);

namespace Palmyr\SymfonyAws\Command;

use Palmyr\SymfonyAws\Factory\SdkFactoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractAwsCommand extends Command implements ServiceSubscriberInterface
{

    protected ContainerInterface $container;

    public function __construct(
        ContainerInterface $container,
        string $name
    )
    {
        $this->container = $container;
        parent::__construct($name);
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        if ( !$input->hasOption("profile") ) {
            $this->addOption("profile", null, InputArgument::OPTIONAL, "The aws profile to use.");
        }

        if ( !$input->hasOption("region") ) {
            $this->addOption("region", null, InputArgument::OPTIONAL, "The aws region to use.");
        }

        $this->setCode([$this, "prepareCommand"]);
    }

    protected function prepareCommand(InputInterface $input, OutputInterface $output): int
    {
        $sdkFactory = $this->getSdkFactory();

        if ( $profile = (string)$input->getOption("profile") ) {
            $sdkFactory->setProfile($profile);
        }

        if ( $region = (string)$input->getOption("region") ) {
            $sdkFactory->setRegion($region);
        }

        return $this->execute($input, $output);
    }

    public static function getSubscribedServices(): array
    {
        return [
            SdkFactoryInterface::class => SdkFactoryInterface::class,
        ];
    }

    private function getSdkFactory(): SdkFactoryInterface
    {
        return $this->container->get(SdkFactoryInterface::class);
    }
}