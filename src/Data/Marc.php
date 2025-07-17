<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API MARC Record DTO
 *
 * Represents a MARC record with leader and fields
 */
final readonly class Marc
{
    public function __construct(
        public string $leader,
        /** @var array<MarcField> */
        public array $fields = [],
    ) {}

    /**
     * Create a Marc from Sierra API response data
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $fields = [];
        if (isset($data['fields']) && is_array($data['fields'])) {
            foreach ($data['fields'] as $fieldData) {
                $fields[] = MarcField::fromArray($fieldData);
            }
        }

        return new self(
            leader: $data['leader'],
            fields: $fields,
        );
    }

    /**
     * Convert the Marc to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'leader' => $this->leader,
            'fields' => array_map(fn (MarcField $field): array => $field->toArray(), $this->fields),
        ];
    }

    /**
     * Get control fields (tag < 010)
     *
     * @return array<MarcField>
     */
    public function getControlFields(): array
    {
        return array_filter($this->fields, fn (MarcField $field): bool => $field->isControlField());
    }

    /**
     * Get data fields (tag >= 010)
     *
     * @return array<MarcField>
     */
    public function getDataFields(): array
    {
        return array_filter($this->fields, fn (MarcField $field): bool => $field->isDataField());
    }

    /**
     * Get fields by tag
     *
     * @return array<MarcField>
     */
    public function getFieldsByTag(string $tag): array
    {
        return array_filter($this->fields, fn (MarcField $field): bool => $field->tag === $tag);
    }

    /**
     * Get the first field by tag
     */
    public function getFirstFieldByTag(string $tag): ?MarcField
    {
        $fields = $this->getFieldsByTag($tag);

        $first = array_key_first($fields);
        if ($first === null) {
            return null;
        }

        return $fields[$first];
    }
}
