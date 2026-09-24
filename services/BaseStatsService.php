<?php

/**
 * @file plugins/generic/publicStats/services/BaseStatsService.php
 *
 * Copyright (c) 2026 Universitat Rovira i Virgili
 * Copyright (c) 2026 Glaux Publicaciones Académicas, S.L.
 * Distributed under the GNU GPL v3. For full terms see the file LICENSE.
 *
 * @class BaseStatsService
 * @ingroup plugins_generic_publicStats
 *
 * @brief Abstract base class for statistics services.
 */

declare(strict_types=1);

namespace APP\plugins\generic\publicStats\services;

use APP\facades\Repo;
use PKP\submission\PKPSubmission;
use Illuminate\Support\Facades\Cache;
use APP\plugins\generic\publicStats\classes\PublicStatsConstants;

abstract class BaseStatsService
{
    protected function cachedOnce(string $key, int $ttl, callable $compute): mixed
    {
        $cached = Cache::get($key);
        if ($cached !== null) {
            return $cached;
        }

        $lockKey = $key . '_lock';

        if (Cache::add($lockKey, 1, PublicStatsConstants::CACHE_LOCK_TTL)) {
            try {
                $value = $compute();
                Cache::put($key, $value, $ttl);
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
    protected function getPublishedSubmissions(int $contextId): iterable
    {
        return Repo::submission()
            ->getCollector()
            ->filterByContextIds([$contextId])
            ->filterByStatus([PKPSubmission::STATUS_PUBLISHED])
            ->getMany();
    }

    protected function getDateRange(?string $dateStart = null, ?string $dateEnd = null): array
    {
        return [
            'start' => $dateStart ?? (PublicStatsConstants::MIN_YEAR . '0101'),
            'end' => $dateEnd ?? date('Ymd', strtotime('yesterday'))
        ];
    }

    protected function formatDateForDB(string $date): string
    {
        return date('Ymd', strtotime($date));
    }

    protected function isEmpty($data): bool
    {
        return $data === null || (is_array($data) && empty($data));
    }
}
