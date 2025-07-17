<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API MARC Field DTO
 *
 * Represents a MARC field with tag and either value (control fields) or data (data fields)
 */
final readonly class MarcField
{
    public function __construct(
        public string $tag,
        public ?string $value = null,
        public ?FieldData $data = null,
    ) {}

    /**
     * Create a MarcField from Sierra API response data
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        // The data structure is: [tag => field_data]
        // e.g., [100 => ['subfields' => [...], 'ind1' => '1', 'ind2' => ' ']]
        $tag = (string) array_key_first($data);
        $fieldContent = $data[$tag];

        $fieldData = null;
        $value = null;

        // Control fields (tag < 010) have a direct value
        if (intval($tag) < 10) {
            $value = is_string($fieldContent) ? $fieldContent : null;
        } elseif (is_array($fieldContent)) {
            // Data fields have subfields, indicators, etc.
            $fieldData = FieldData::fromArray($fieldContent);
        }

        return new self(
            tag: $tag,
            value: $value,
            data: $fieldData,
        );
    }

    /**
     * Convert the MarcField to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        if ($this->value !== null) {
            // Control field: [tag => value]
            return [
                $this->tag => $this->value,
            ];
        }

        if ($this->data instanceof \VincentAuger\SierraSdk\Data\FieldData) {
            // Data field: [tag => field_data]
            return [
                $this->tag => $this->data->toArray(),
            ];
        }

        return [
            $this->tag => null,
        ];
    }

    /**
     * Check if this is a control field (tag < 010)
     */
    public function isControlField(): bool
    {
        return intval($this->tag) < 10;
    }

    /**
     * Check if this is a data field (tag >= 010)
     */
    public function isDataField(): bool
    {
        return ! $this->isControlField();
    }

    public function getSubfieldDataByCode(string $code): ?string
    {
        if (! $this->data instanceof \VincentAuger\SierraSdk\Data\FieldData || ! $this->isDataField()) {
            return null; // Not a data field or no data
        }

        // loook for code in subfields
        foreach ($this->data->subfields as $subfield) {
            if ($subfield->code === $code) {
                return $subfield->data; // Return the value of the subfield
            }
        }

        return null; // Subfield not found
    }
}
