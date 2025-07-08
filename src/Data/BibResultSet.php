<?php

namespace VincentAuger\SierraSdk\Data;


/**
 * Sierra API Bib Object List
 *
 * This class represents a list of Bib objects returned by the Sierra API.
 *
 */
class BibResultSet
{

    /**
     * @param  int  $total  Total number of Bib objects found
     * @param  int  $start  Starting index of the returned Bib objects
     * @param  array<BibObject>  $entries  List of Bib objects
     */
    public function __construct(
        public int $total,
        public int $start,
        public array $entries
    ) {}

    /**
     * Create a BibResultSet from Sierra API response data
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $bibs = [];
        foreach ($data['entries'] as $entry) {
            $bibs[] = BibObject::fromArray($entry);
        }

        return new self(
            total: $data['total'],
            start: $data['start'],
            entries: $bibs
        );
    }

    /**
     * Convert the BibResultSet to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $entries = [];
        foreach ($this->entries as $bib) {
            $entries[] = $bib->toArray();
        }

        return [
            'total' => $this->total,
            'start' => $this->start,
            'entries' => $entries,
        ];
    }
}