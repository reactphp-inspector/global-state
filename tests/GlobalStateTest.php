<?php declare(strict_types=1);

namespace ReactInspector\Tests;

use ReactInspector\GlobalState;
use WyriHaximus\TestUtilities\TestCase;

/**
 * @internal
 */
final class GlobalStateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        GlobalState::clear();
    }

    public function testBootstrappedState(): void
    {
        GlobalState::bootstrap();
        self::assertSame([
            'inspector.metrics' => 0.0,
        ], GlobalState::get());
    }

    public function testGlobalState(): void
    {
        self::assertSame([], GlobalState::get());
        GlobalState::set('key', 1.0);
        self::assertSame(['key' => 1.0], GlobalState::get());
        GlobalState::incr('key');
        self::assertSame(['key' => 2.0], GlobalState::get());
        GlobalState::incr('key', 3.0);
        self::assertSame(['key' => 5.0], GlobalState::get());
        GlobalState::reset();
        self::assertSame(['key' => 0.0], GlobalState::get());
        GlobalState::clear();
        self::assertSame([], GlobalState::get());
        GlobalState::incr('key', 3.0);
        self::assertSame(['key' => 3.0], GlobalState::get());
        GlobalState::decr('key');
        self::assertSame(['key' => 2.0], GlobalState::get());
    }
}
