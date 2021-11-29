<?php

declare(strict_types=1);

namespace Shared\Infra\Settings;

interface SettingsInterface
{
    /** @param non-empty-string $key */
    public function get(string $key): mixed;
}
