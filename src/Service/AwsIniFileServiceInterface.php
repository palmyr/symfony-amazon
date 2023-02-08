<?php

declare(strict_types=1);

namespace Palmyr\SymfonyAws\Service;

use Palmyr\SymfonyAws\Model\AwsProfileModelInterface;

interface AwsIniFileServiceInterface
{
    public const AWS_INI_FILENAME = 'credentials';

    public function loadProfile(string $profile, string $filename = self::AWS_INI_FILENAME): ?AwsProfileModelInterface;

    public function saveProfile(AwsProfileModelInterface $awsProfileModel, string $filename = self::AWS_INI_FILENAME): void;
}
