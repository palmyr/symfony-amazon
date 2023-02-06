<?php

declare(strict_types=1);

namespace Palmyr\SymfonyAws\Factory;

use Aws\Sdk;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class SdkFactory implements SdkFactoryInterface
{

    protected PropertyAccessorInterface $propertyAccessor;

    protected array $options;

    public function __construct(
        PropertyAccessorInterface $propertyAccessor,
        array $options = []
    )
    {
        $this->propertyAccessor = $propertyAccessor;
        $this->options = $options;
    }

    public function build(array $options): Sdk
    {

        $options = array_merge($this->options, $options);

        if ( !isset($options["profile"] ) ) {
            $options["profile"] = "default";
        }

        if ( !isset($options["region"] ) ) {
            $options["region"] = "us-east-1";
        }

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
