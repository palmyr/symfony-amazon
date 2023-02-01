<?php

declare(strict_types=1);

namespace Palmyr\SymfonyAws\Factory;

use Aws\Sdk;

class SdkFactory implements SdkFactoryInterface
{

    protected array $options;

    public function __construct(
        array $options = []
    )
    {
        $this->options = $options;
    }

    public function build(array $options): Sdk
    {

        $options = array_merge($this->options, $options);
        return new Sdk($options);
    }
}
