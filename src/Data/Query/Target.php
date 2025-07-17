<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data\Query;

/**
 * Represents a Sierra API query target
 */
final readonly class Target
{
    public function __construct(
        public Record $record,
        public ?int $id = null,
        public ?Field $field = null,
        public ?int $specialField = null,
    ) {}

    /**
     * Convert the target to an array for JSON serialization
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = ['record' => $this->record->toArray()];

        if ($this->id !== null) {
            $result['id'] = $this->id;
        }

        if ($this->field instanceof \VincentAuger\SierraSdk\Data\Query\Field) {
            $result['field'] = $this->field->toArray();
        }

        if ($this->specialField !== null) {
            $result['specialField'] = $this->specialField;
        }

        return $result;
    }
}
