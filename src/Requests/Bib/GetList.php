<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Requests\Bib;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\CreatesDtoFromResponse;

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

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/bibs';
    }

    /**
     * Set the maximum number of results to return.
     *
     * @param int $limit The maximum number of results (must be positive)
     * @return self
     */
    public function addLimit(int $limit): self
    {
        $this->query()->add('limit', $limit);
        return $this;
    }

    /**
     * Set the beginning record (zero-indexed) of the result set returned.
     *
     * @param int $offset The offset for pagination (must be non-negative)
     * @return self
     */
    public function addOffset(int $offset): self
    {
        $this->query()->add('offset', $offset);
        return $this;
    }

    /**
     * Filter by a comma-delimited list of IDs of bibs to retrieve.
     *
     * @param array<int|string> $ids Array of bib IDs
     * @return self
     */
    public function ids(array $ids): self
    {
        $this->query()->add('id', implode(',', $ids));
        return $this;
    }

    /**
     * Specify a comma-delimited list of fields to retrieve.
     *
     * @param array<string> $fields Array of field names
     * @return self
     */
    public function fields(array $fields): self
    {
        $this->query()->add('fields', implode(',', $fields));
        return $this;
    }

    /**
     * Filter by the creation date of bibs to retrieve.
     * Can be a single date or a range (e.g., "2024-01-01,2024-12-31").
     *
     * @param string $createdDate Date or date range in ISO format
     * @return self
     */
    public function createdDate(string $createdDate): self
    {
        $this->query()->add('createdDate', $createdDate);
        return $this;
    }

    /**
     * Filter by the modification date of bibs to retrieve.
     * Can be a single date or a range (e.g., "2024-01-01,2024-12-31").
     *
     * @param string $updatedDate Date or date range in ISO format
     * @return self
     */
    public function updatedDate(string $updatedDate): self
    {
        $this->query()->add('updatedDate', $updatedDate);
        return $this;
    }

    /**
     * Filter by the deletion date of deleted bibs to retrieve.
     * Can be a single date or a range (e.g., "2024-01-01,2024-12-31").
     *
     * @param string $deletedDate Date or date range in ISO format
     * @return self
     */
    public function deletedDate(string $deletedDate): self
    {
        $this->query()->add('deletedDate', $deletedDate);
        return $this;
    }

    /**
     * Filter by deletion status.
     * Set to true to retrieve only deleted bibs, false for non-deleted bibs.
     *
     * @param bool $deleted Whether to retrieve deleted bibs
     * @return self
     */
    public function deleted(bool $deleted): self
    {
        $this->query()->add('deleted', $deleted ? 'true' : 'false');
        return $this;
    }

    /**
     * Filter by suppressed flag value of bibs to retrieve.
     *
     * @param bool $suppressed Whether to retrieve suppressed bibs
     * @return self
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
     * @param array<string> $locations Array of location codes
     * @return self
     */
    public function locations(array $locations): self
    {
        $this->query()->add('locations', implode(',', $locations));
        return $this;
    }

}