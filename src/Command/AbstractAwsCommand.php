<?php declare(strict_types=1);

namespace Palmyr\SymfonyAws\Command;

use Symfony\Component\Console\Command\Command;
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
}