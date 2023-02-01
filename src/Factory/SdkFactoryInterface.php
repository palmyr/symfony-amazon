<?php

declare(strict_types=1);

namespace Palmyr\SymfonyAws\Factory;

use Aws\Sdk;

interface SdkFactoryInterface
{
    public function build(array $options): Sdk;
}
