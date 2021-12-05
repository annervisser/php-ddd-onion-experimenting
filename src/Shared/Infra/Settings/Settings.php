<?php

declare(strict_types=1);

namespace Shared\Infra\Settings;

use function array_replace_recursive;
use function explode;

/** @psalm-immutable */
final class Settings implements SettingsInterface
{
    /** @psalm-param array<string, mixed> $settings */
    public function __construct(private readonly array $settings = [])
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

    /** @psalm-param array<string, mixed> $settings */
    public function addSettings(array $settings): self
    {
        return new self(array_replace_recursive($this->settings, $settings));
    }
}
