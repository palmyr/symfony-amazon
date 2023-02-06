<?php

declare(strict_types=1);

namespace Palmyr\SymfonyAws\Factory;

use Aws\Sdk;

interface SdkFactoryInterface
{
    public function build(array $options): Sdk;

    public function getProfile(string $profile): ?string;

    public function setProfile(string $profile): void;

    public function getRegion(string $region): ?string;

    public function setRegion(string $region): void;
}
