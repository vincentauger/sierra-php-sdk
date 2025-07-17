<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API Query Result Set DTO
 *
 * Represents a set of query results with pagination information
 */
final readonly class QueryResultSet
{
    /**
     * @param  int|null  $total  The total number of results
     * @param  int|null  $start  The starting position of this set
     * @param  array<QueryEntry>  $entries  The bool search result entries
     */
    public function __construct(
        public ?int $total = null,
        public ?int $start = null,
        public array $entries = [],
    ) {}

    /**
     * Create a QueryResultSet from Sierra API response data
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $entries = [];
        foreach ($data['entries'] ?? [] as $entry) {
            $entries[] = QueryEntry::fromArray($entry);
        }

        return new self(
            total: $data['total'] ?? null,
            start: $data['start'] ?? null,
            entries: $entries,
        );
    }

    /**
     * Convert the QueryResultSet to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'start' => $this->start,
            'entries' => array_map(fn (QueryEntry $entry) => $entry->toArray(), $this->entries),
        ];
    }
}
