<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Traits;

/**
 * Trait for handling Sierra API query parameter formatting.
 */
trait QueryParam
{
    /**
     * Format a range query parameter for the Sierra API.
     *
     * @param  string  $parameter  The parameter name
     * @param  string|null  $startValue  Start value (inclusive), null for open start
     * @param  string|null  $endValue  End value (inclusive), null for open end
     *
     * @throws \InvalidArgumentException When both parameters are null
     */
    protected function addRangeParam(string $parameter, ?string $startValue = null, ?string $endValue = null): self
    {
        if ($startValue === null && $endValue === null) {
            throw new \InvalidArgumentException("At least one of start or end value must be provided for {$parameter} range filtering");
        }

        $range = sprintf('[%s,%s]', $startValue ?? '', $endValue ?? '');
        $this->query()->add($parameter, $range);

        return $this;
    }

    /**
     * Format a date range query parameter for the Sierra API.
     *
     * @param  string  $parameter  The parameter name
     * @param  \DateTime|null  $startDate  Start date (inclusive), null for open start
     * @param  \DateTime|null  $endDate  End date (inclusive), null for open end
     *
     * @throws \InvalidArgumentException When both parameters are null
     */
    protected function addDateRangeParam(string $parameter, ?\DateTime $startDate = null, ?\DateTime $endDate = null): self
    {
        if (! $startDate instanceof \DateTime && ! $endDate instanceof \DateTime) {
            throw new \InvalidArgumentException("At least one of start or end date must be provided for {$parameter} range filtering");
        }

        $start = $startDate instanceof \DateTime ? $this->formatDateForSierra($startDate) : '';
        $end = $endDate instanceof \DateTime ? $this->formatDateForSierra($endDate) : '';

        $range = sprintf('[%s,%s]', $start, $end);
        $this->query()->add($parameter, $range);

        return $this;
    }

    /**
     * Format a date parameter for the Sierra API.
     *
     * @param  string  $parameter  The parameter name
     * @param  \DateTime  $date  The date to format
     */
    protected function addDateParam(string $parameter, \DateTime $date): self
    {
        $this->query()->add($parameter, $this->formatDateForSierra($date));

        return $this;
    }

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

    /**
     * Format a DateTime object for the Sierra API.
     *
     * @param  \DateTime  $date  The date to format
     */
    protected function formatDateForSierra(\DateTime $date): string
    {
        return $date->format('Y-m-d\TH:i:s\Z');
    }
}
