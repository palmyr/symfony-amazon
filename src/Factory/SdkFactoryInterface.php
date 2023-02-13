<?php

declare(strict_types=1);

namespace Palmyr\SymfonyAws\Factory;

use Aws\Sdk;
use Palmyr\SymfonyAws\Model\AwsProfileModelInterface;

interface SdkFactoryInterface
{
    public function build(array $options = []): Sdk;

    public function buildFromProfile(array $options = []): Sdk;

    public function getProfile(): ?string;

    public function setProfile(string $profile): void;

    public function getRegion(): ?string;

    public function setRegion(string $region): void;
}
