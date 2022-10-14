<?php

declare(strict_types=1);

namespace ReactInspector;

use WyriHaximus\Metrics\Registry;

final class GlobalState
{
    private static Registry|null $registry = null;

    /** @var array<callable> */
    private static array $subscribers = [];

    public static function register(Registry $registry): void
    {
        self::$registry = $registry;

        foreach (self::$subscribers as $subscriber) {
            $subscriber($registry);
        }

        self::$subscribers = [];
    }

    /** @param (callable(Registry): void) $subscriber */
    public static function subscribe(callable $subscriber): void
    {
        if (self::$registry instanceof Registry) {
            $subscriber(self::$registry);

            return;
        }

        self::$subscribers[] = $subscriber;
    }
}
