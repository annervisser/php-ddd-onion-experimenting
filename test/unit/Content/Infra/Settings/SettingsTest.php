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

    public function testAddSettings(): void
    {
        // Basic value
        $settings = new Settings(['a' => 'valueA', 'nested' => ['b' => 'valueB']]);
        $settings = $settings->addSettings(['a' => 'newValueA']);
        self::assertEquals('newValueA', $settings->get('a'));

        // Nested settings
        $settings = $settings->addSettings(['nested' => ['b' => 'newValueB']]);
        self::assertEquals('newValueB', $settings->get('nested.b'));

        // New nested setting not overwriting existing
        $settings = $settings->addSettings(['nested' => ['c' => 'valueC']]);
        self::assertEquals('newValueB', $settings->get('nested.b'));
    }
}
