<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Requests\Bib;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\CreatesDtoFromResponse;
use VincentAuger\SierraSdk\Traits\QueryParam;

/**
 * Retrieve a list of bibliographic records from Sierra.
 *
 * This request allows you to retrieve bibliographic records with various filtering
 * and pagination options. You can filter by creation date, modification date,
 * deletion date, suppressed status, and location codes.
 */
final class GetList extends Request
{
    use CreatesDtoFromResponse;
    use QueryParam;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/bibs';
    }

    /**
     * Set the maximum number of results to return.
     *
     * @param  int  $limit  The maximum number of results (must be positive)
     */
    public function addLimit(int $limit): self
    {
        $this->query()->add('limit', $limit);

        return $this;
    }

    /**
     * Set the beginning record (zero-indexed) of the result set returned.
     *
     * @param  int  $offset  The offset for pagination (must be non-negative)
     */
    public function addOffset(int $offset): self
    {
        $this->query()->add('offset', $offset);

        return $this;
    }

    /**
     * Filter by a comma-delimited list of IDs of bibs to retrieve.
     *
     * For exact ID matching:
     * id=1000004
     *
     * For multiple IDs:
     * id=[1000004,1000054,1000055]
     *
     * @param  array<int|string>  $ids  Array of bib IDs
     */
    public function ids(array $ids): self
    {
        return $this->addIdsParam($ids);
    }

    /**
     * Filter by ID range.
     *
     * @param  int|string|null  $startId  Start ID (inclusive), null for open start
     * @param  int|string|null  $endId  End ID (inclusive), null for open end
     *
     * @throws \InvalidArgumentException When both parameters are null
     */
    public function idRange(int|string|null $startId = null, int|string|null $endId = null): self
    {
        return $this->addIdRangeParam($startId, $endId);
    }

    /**
     * Specify a comma-delimited list of fields to retrieve.
     *
     * @param  array<string>  $fields  Array of field names
     */
    public function fields(array $fields): self
    {
        $this->query()->add('fields', implode(',', $fields));

        return $this;
    }

    /**
     * Filter by the creation date of bibs to retrieve.
     *
     * For exact date matching:
     * createdDate=2013-12-10T17:16:35Z
     *
     * For date range (inclusive):
     * createdDate=[2013-12-10T17:16:35Z,2013-12-13T21:34:35Z]
     *
     * @param  \DateTime  $createdDate  Exact creation date
     */
    public function createdDate(\DateTime $createdDate): self
    {
        return $this->addDateParam('createdDate', $createdDate);
    }

    /**
     * Filter by a creation date range (inclusive).
     *
     * From date and after (inclusive):
     * createdDate=[2013-12-10T17:16:35Z,]
     *
     * Up to and including date:
     * createdDate=[,2013-12-13T21:34:35Z]
     *
     * From start to end (inclusive):
     * createdDate=[2013-12-10T17:16:35Z,2013-12-13T21:34:35Z]
     *
     * @param  \DateTime|null  $startDate  Start of the date range (inclusive), null for open start
     * @param  \DateTime|null  $endDate  End of the date range (inclusive), null for open end
     *
     * @throws \InvalidArgumentException When both parameters are null
     */
    public function createdDateRange(?\DateTime $startDate = null, ?\DateTime $endDate = null): self
    {
        return $this->addDateRangeParam('createdDate', $startDate, $endDate);
    }

    /**
     * Filter by the modification date of bibs to retrieve.
     *
     * For exact date matching:
     * updatedDate=2013-12-10T17:16:35Z
     *
     * For date range (inclusive):
     * updatedDate=[2013-12-10T17:16:35Z,2013-12-13T21:34:35Z]
     *
     * @param  \DateTime  $updatedDate  Exact modification date
     */
    public function updatedDate(\DateTime $updatedDate): self
    {
        return $this->addDateParam('updatedDate', $updatedDate);
    }

    /**
     * Filter by a modification date range (inclusive).
     *
     * From date and after (inclusive):
     * updatedDate=[2013-12-10T17:16:35Z,]
     *
     * Up to and including date:
     * updatedDate=[,2013-12-13T21:34:35Z]
     *
     * From start to end (inclusive):
     * updatedDate=[2013-12-10T17:16:35Z,2013-12-13T21:34:35Z]
     *
     * @param  \DateTime|null  $startDate  Start of the date range (inclusive), null for open start
     * @param  \DateTime|null  $endDate  End of the date range (inclusive), null for open end
     *
     * @throws \InvalidArgumentException When both parameters are null
     */
    public function updatedDateRange(?\DateTime $startDate = null, ?\DateTime $endDate = null): self
    {
        return $this->addDateRangeParam('updatedDate', $startDate, $endDate);
    }

    /**
     * Filter by the deletion date of deleted bibs to retrieve.
     *
     * For exact date matching:
     * deletedDate=2013-12-10T17:16:35Z
     *
     * For date range (inclusive):
     * deletedDate=[2013-12-10T17:16:35Z,2013-12-13T21:34:35Z]
     *
     * @param  \DateTime  $deletedDate  Exact deletion date
     */
    public function deletedDate(\DateTime $deletedDate): self
    {
        return $this->addDateParam('deletedDate', $deletedDate);
    }

    /**
     * Filter by a deletion date range (inclusive).
     *
     * From date and after (inclusive):
     * deletedDate=[2013-12-10T17:16:35Z,]
     *
     * Up to and including date:
     * deletedDate=[,2013-12-13T21:34:35Z]
     *
     * From start to end (inclusive):
     * deletedDate=[2013-12-10T17:16:35Z,2013-12-13T21:34:35Z]
     *
     * @param  \DateTime|null  $startDate  Start of the date range (inclusive), null for open start
     * @param  \DateTime|null  $endDate  End of the date range (inclusive), null for open end
     *
     * @throws \InvalidArgumentException When both parameters are null
     */
    public function deletedDateRange(?\DateTime $startDate = null, ?\DateTime $endDate = null): self
    {
        return $this->addDateRangeParam('deletedDate', $startDate, $endDate);
    }

    /**
     * Filter by deletion status.
     * Set to true to retrieve only deleted bibs, false for non-deleted bibs.
     *
     * @param  bool  $deleted  Whether to retrieve deleted bibs
     */
    public function deleted(bool $deleted): self
    {
        $this->query()->add('deleted', $deleted ? 'true' : 'false');

        return $this;
    }

    /**
     * Filter by suppressed flag value of bibs to retrieve.
     *
     * @param  bool  $suppressed  Whether to retrieve suppressed bibs
     */
    public function suppressed(bool $suppressed): self
    {
        $this->query()->add('suppressed', $suppressed ? 'true' : 'false');

        return $this;
    }

    /**
     * Filter by location codes.
     * Can include a single wildcard '*' to represent one or more final characters
     * (e.g., "mult*" or "mul*").
     *
     * @param  array<string>  $locations  Array of location codes
     */
    public function locations(array $locations): self
    {
        $this->query()->add('locations', implode(',', $locations));

        return $this;
    }
}
