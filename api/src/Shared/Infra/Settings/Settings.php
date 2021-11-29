<?php

declare(strict_types=1);

namespace Shared\Infra\Settings;

class Settings implements SettingsInterface
{
    /** @psalm-param array<string, mixed> $settings */
    public function __construct(private array $settings)
    {
    }

    public function get(string $key): mixed
    {
        return $this->settings[$key];
    }
}
