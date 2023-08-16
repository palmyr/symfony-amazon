<?php declare(strict_types=1);

namespace Palmyr\SymfonyAws\DependencyInjection;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class SymfonyAwsExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container): void
    {

        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . "/../../Resources/config"));

        $container->setParameter("palmyr.aws.sdk.options", $config["sdk"] ?? []);

        $loader->load("services.yaml");
        $loader->load("clients.yaml");
        $loader->load("commands.yaml");


    }

}