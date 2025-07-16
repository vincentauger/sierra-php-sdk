<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Traits;

/**
 * Trait for handling ID query parameters.
 */
trait HasIdParams
{
    /**
     * Format an ID range query parameter for the Sierra API.
     *
     * @param  int|string|null  $startId  Start ID (inclusive), null for open start
     * @param  int|string|null  $endId  End ID (inclusive), null for open end
     *
     * @throws \InvalidArgumentException When both parameters are null
     */
    protected function addIdRangeParam(int|string|null $startId = null, int|string|null $endId = null): self
    {
        if ($startId === null && $endId === null) {
            throw new \InvalidArgumentException('At least one of startId or endId must be provided for range filtering');
        }

        $range = sprintf('[%s,%s]', $startId ?? '', $endId ?? '');
        $this->query()->add('id', $range);

        return $this;
    }

    /**
     * Format multiple IDs for the Sierra API.
     * Single ID: id=1000004
     * Multiple IDs: id=1000004,1000054,1000055
     *
     * @param  array<int|string>  $ids  Array of IDs
     */
    protected function addIdsParam(array $ids): self
    {
        $this->query()->add('id', implode(',', $ids));

        return $this;
    }
}
