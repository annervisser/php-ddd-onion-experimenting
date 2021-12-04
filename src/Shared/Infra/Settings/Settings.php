<?php

declare(strict_types=1);

namespace Shared\Infra\Settings;

use function explode;

class Settings implements SettingsInterface
{
    /** @psalm-param array<string, mixed> $settings */
    public function __construct(private array $settings)
    {
    }

    public function get(string $key): mixed
    {
        $parts  = explode('.', $key);
        $return = $this->settings;
        foreach ($parts as $part) {
            $return = $return[$part];
        }

        return $return;
    }
}
