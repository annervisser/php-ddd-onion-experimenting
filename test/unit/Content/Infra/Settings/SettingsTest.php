<?php

declare(strict_types=1);

namespace ContentTest\Infra\Settings;

use PHPUnit\Framework\TestCase;
use Shared\Infra\Settings\Settings;

/** @covers \Shared\Infra\Settings\Settings */
class SettingsTest extends TestCase
{
    public function testGet(): void
    {
        $settings = new Settings([
            'toplevel' => 'toplevelvalue',
            'nested' => ['value' => 'nestedvalue'],
            'doublenested' => [
                'nested' => ['value' => 'doublenestedvalue'],
            ],
        ]);
        self::assertEquals('toplevelvalue', $settings->get('toplevel'));
        self::assertEquals('nestedvalue', $settings->get('nested.value'));
        self::assertEquals('doublenestedvalue', $settings->get('doublenested.nested.value'));
        self::assertEquals(['value' => 'nestedvalue'], $settings->get('nested'));
    }
}
