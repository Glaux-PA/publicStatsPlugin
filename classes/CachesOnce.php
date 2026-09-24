<?php

/**
 * @file plugins/generic/publicStats/classes/CachesOnce.php
 *
 * Copyright (c) 2026 Universitat Rovira i Virgili
 * Copyright (c) 2026 Glaux Publicaciones Académicas, S.L.
 * Distributed under the GNU GPL v3. For full terms see the file LICENSE.
 *
 * @brief Shared single-flight caching for request-time computations.
 */

declare(strict_types=1);

namespace APP\plugins\generic\publicStats\classes;

use Illuminate\Support\Facades\Cache;

trait CachesOnce
{
    protected function cachedOnce(string $key, int $ttl, callable $compute, ?callable $shouldCache = null): mixed
    {
        $cached = Cache::get($key);
        if ($cached !== null) {
            return $cached;
        }

        $lockKey = $key . '_lock';

        if (Cache::add($lockKey, 1, PublicStatsConstants::CACHE_LOCK_TTL)) {
            try {
                $value = $compute();
                if ($shouldCache === null || $shouldCache($value)) {
                    Cache::put($key, $value, $ttl);
                }
            } finally {
                Cache::forget($lockKey);
            }

            return $value;
        }

        for ($i = 0; $i < PublicStatsConstants::CACHE_LOCK_WAIT_TRIES; $i++) {
            usleep(PublicStatsConstants::CACHE_LOCK_WAIT_DELAY);

            $cached = Cache::get($key);
            if ($cached !== null) {
                return $cached;
            }
        }

        return $compute();
    }
}
