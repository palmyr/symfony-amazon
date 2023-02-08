<?php

declare(strict_types=1);

namespace Palmyr\SymfonyAws\Factory;

use Aws\Sdk;
use Palmyr\SymfonyAws\Model\AwsProfileModelInterface;
use Palmyr\SymfonyAws\Service\AwsIniFileServiceInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class SdkFactory implements SdkFactoryInterface
{

    protected AwsIniFileServiceInterface $awsIniFileService;

    protected PropertyAccessorInterface $propertyAccessor;

    protected array $options;

    public function __construct(
        AwsIniFileServiceInterface $awsIniFileService,
        PropertyAccessorInterface $propertyAccessor,
        array $options = []
    )
    {
        $this->awsIniFileService = $awsIniFileService;
        $this->propertyAccessor = $propertyAccessor;
        $this->options = $options;
    }

    public function build(array $options = []): Sdk
    {

        $options = array_merge($this->options, $options);

        if ( !isset($options["profile"] ) ) {
            $options["profile"] = "default";
        }

        $profile = $options["profile"];

        if ( !isset($options["region"] ) ) {
            if ( $profileData = $this->awsIniFileService->loadProfile($profile) ) {
                $options["region"] = $profileData->getRegion();
            } else {
                $options["region"] = "us-east-1";
            }
        }

        return new Sdk($options);
    }

    public function buildFromProfileModel(AwsProfileModelInterface $profileModel): Sdk
    {
        $options = $profileModel->getData();

        $options["profile"] = $profileModel->getProfile();

        return new Sdk($options);
    }

    public function getOption(string $key): mixed
    {
        return $this->propertyAccessor->getValue($this->options, $key);
    }

    public function setOption(string $key, mixed $value): void
    {
        $this->propertyAccessor->setValue($this->options, $key, $value);
    }

    public function getProfile(string $profile): ?string
    {
        return $this->propertyAccessor->getValue($this->options, '[profile]');
    }

    public function setProfile(string $profile): void
    {
        $this->propertyAccessor->setValue($this->options, '[profile]', $profile);
    }

    public function getRegion(string $region): ?string
    {
        return $this->propertyAccessor->getValue($this->options, '[region]');
    }

    public function setRegion(string $region): void
    {
        $this->propertyAccessor->setValue($this->options, '[region]', $region);
    }
}
