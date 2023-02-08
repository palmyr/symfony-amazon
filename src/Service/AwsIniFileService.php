<?php

declare(strict_types=1);

namespace Palmyr\SymfonyAws\Service;

use Aws\Credentials\CredentialProvider;
use Palmyr\SymfonyAws\Model\AwsIniModel;
use Palmyr\SymfonyAws\Model\AwsIniModelInterface;
use Palmyr\SymfonyAws\Model\AwsProfileModel;
use Palmyr\SymfonyAws\Model\AwsProfileModelInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class AwsIniFileService implements AwsIniFileServiceInterface
{
    protected PropertyAccessorInterface $propertyAccessor;

    public function __construct(
        PropertyAccessorInterface $propertyAccessor
    ) {
        $this->propertyAccessor = $propertyAccessor;
    }

    public function loadProfile(string $profile, string $filename = self::AWS_INI_FILENAME): ?AwsProfileModelInterface
    {
        $data = $this->parseAwsIni(self::AWS_INI_FILENAME);

        if ( array_key_exists($profile, $data) ) {
            return new AwsProfileModel($profile, $data[$profile]);
        }

        return null;
    }

    public function saveProfile(AwsProfileModelInterface $awsProfileModel, string $filename = self::AWS_INI_FILENAME): void
    {
        $data = $this->parseAwsIni(self::AWS_INI_FILENAME);

        $data[$awsProfileModel->getProfile()] = $awsProfileModel->getData();

        $this->writeAwsIni($data, self::AWS_INI_FILENAME);
    }

    protected function parseAwsIni(string $filename): array
    {
        return \Aws\parse_ini_file($this->getFileName($filename), true, INI_SCANNER_RAW);
    }

    protected function writeAwsIni(array $data, string $filename): void
    {
        $file = new  \SplFileObject($this->getFileName($filename), 'w');

        foreach ($data as $profile => $profileData) {
            $file->fwrite('['.$profile.']' . PHP_EOL);
            foreach ($profileData as $key => $value) {
                $file->fwrite($key.'='.$value . PHP_EOL);
            }

            $file->fwrite(PHP_EOL);
        }

        $file->fflush();
    }

    protected function getFileName(string $filename): string
    {
        return getenv(CredentialProvider::ENV_SHARED_CREDENTIALS_FILE) ?: (self::getHomeDir() . "/.aws/" . $filename);
    }

    protected function getHomeDir(): ?string
    {
        // On Linux/Unix-like systems, use the HOME environment variable
        if ($homeDir = getenv('HOME')) {
            return $homeDir;
        }

        // Get the HOMEDRIVE and HOMEPATH values for Windows hosts
        $homeDrive = getenv('HOMEDRIVE');
        $homePath = getenv('HOMEPATH');

        return ($homeDrive && $homePath) ? $homeDrive . $homePath : null;
    }
}
