<?php

declare(strict_types=1);

namespace Palmyr\SymfonyAws\Model;

interface AwsProfileModelInterface
{
    public function getProfile(): string;

    public function getRegion(): string;

    public function getSessionTokenExpiresAt(): ?\DateTimeImmutable;

    public function get(string $key): ?string;

    public function getData(): array;

    public function set(string $key, string $value): AwsProfileModelInterface;
}
