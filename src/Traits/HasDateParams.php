<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Traits;

/**
 * Trait for handling date query parameters.
 */
trait HasDateParams
{
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
     * Format a DateTime object for the Sierra API.
     *
     * @param  \DateTime  $date  The date to format
     */
    protected function formatDateForSierra(\DateTime $date): string
    {
        return $date->format('Y-m-d\TH:i:s\Z');
    }
}
