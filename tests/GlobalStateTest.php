<?php

declare(strict_types=1);

namespace ReactInspector\Tests;

use ReactInspector\GlobalState;
use WyriHaximus\Metrics\Configuration;
use WyriHaximus\Metrics\InMemory\Registry;
use WyriHaximus\TestUtilities\TestCase;

final class GlobalStateTest extends TestCase
{
    /** @test */
    public function subscribeAndRegister(): void
    {
        $count    = 0;
        $registry = new Registry(Configuration::create());

        for ($i = 0; $i < 13; $i++) {
            GlobalState::subscribe(static function (\WyriHaximus\Metrics\Registry $passRegistry) use ($registry, &$count): void {
                self::assertSame($registry, $passRegistry);
                $count++;
            });
        }

        GlobalState::register($registry);

        for ($i = 0; $i < 13; $i++) {
            GlobalState::subscribe(static function (\WyriHaximus\Metrics\Registry $passRegistry) use ($registry, &$count): void {
                self::assertSame($registry, $passRegistry);
                $count++;
            });
        }

        self::assertSame(26, $count);
    }
}
