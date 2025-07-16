<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API Bib Search Result Set DTO
 *
 * Represents a set of bib search results with pagination information
 */
final readonly class BibSearchResultSet
{
    /**
     * @param  int  $count  The total number of results based on query limit
     * @param  int|null  $total  The total number of records in the result set
     * @param  int|null  $start  The starting position of this set
     * @param  array<BibSearchResultEntry>  $entries  The search result entries in this set
     */
    public function __construct(
        public int $count,
        public ?int $total = null,
        public ?int $start = null,
        public array $entries = [],
    ) {}

    /**
     * Create a BibSearchResultSet from Sierra API response data
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $entries = [];
        foreach ($data['entries'] ?? [] as $entry) {
            $entries[] = BibSearchResultEntry::fromArray($entry);
        }

        return new self(
            count: $data['count'],
            total: $data['total'] ?? null,
            start: $data['start'] ?? null,
            entries: $entries,
        );
    }

    /**
     * Convert the BibSearchResultSet to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'count' => $this->count,
            'total' => $this->total,
            'start' => $this->start,
            'entries' => array_map(fn (BibSearchResultEntry $entry) => $entry->toArray(), $this->entries),
        ];
    }
}
