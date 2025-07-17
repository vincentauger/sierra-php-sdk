<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data\Query;

/**
 * Builder for creating Sierra API query targets with a fluent interface
 */
final class TargetBuilder
{
    public function __construct(
        private Record $record,
        private ?int $id = null,
        private ?Field $field = null,
        private ?int $specialField = null,
    ) {}

    /**
     * Set the record relation type and tag (for soft-linked records)
     */
    public function withRelation(string $relationType, string $relationTag): self
    {
        $this->record = new Record(
            $this->record->type,
            $relationType,
            $relationTag
        );

        return $this;
    }

    /**
     * Target a fixed-length field or record property by ID
     */
    public function fieldId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Target a non-MARC variable-length field by tag
     */
    public function field(string $tag): self
    {
        $this->field = new Field(tag: $tag);
        return $this;
    }

    /**
     * Target a MARC field
     */
    public function marcField(
        string $marcTag,
        ?string $ind1 = null,
        ?string $ind2 = null,
        ?string $subfields = null
    ): self {
        $this->field = new Field(
            marcTag: $marcTag,
            ind1: $ind1,
            ind2: $ind2,
            subfields: $subfields
        );
        return $this;
    }

    /**
     * Target a MARC leader or control field element
     */
    public function specialField(int $specialField): self
    {
        $this->specialField = $specialField;
        return $this;
    }

    /**
     * Create an expression builder for this target
     */
    public function where(): ExpressionBuilder
    {
        $target = new Target(
            $this->record,
            $this->id,
            $this->field,
            $this->specialField
        );

        return new ExpressionBuilder($target);
    }

    /**
     * Create a query with the target and a simple "equals" expression
     */
    public function equals(string ...$values): Query
    {
        return $this->where()->equals(...$values);
    }

    /**
     * Create a query with the target and a simple "has" expression
     */
    public function has(string ...$values): Query
    {
        return $this->where()->has(...$values);
    }

    /**
     * Create a query with the target and a simple "range" expression
     */
    public function range(string $from, string $to): Query
    {
        return $this->where()->range($from, $to);
    }

    /**
     * Create a query with the target and a simple "greater" expression
     */
    public function greater(string $value): Query
    {
        return $this->where()->greater($value);
    }

    /**
     * Create a query with the target and a simple "less" expression
     */
    public function less(string $value): Query
    {
        return $this->where()->less($value);
    }

    /**
     * Create a query with the target and a simple "between" expression
     */
    public function between(string $from, string $to): Query
    {
        return $this->where()->between($from, $to);
    }

    /**
     * Create a query with the target and a simple "starts_with" expression
     */
    public function startsWith(string $value): Query
    {
        return $this->where()->startsWith($value);
    }

    /**
     * Create a query with the target and a simple "empty" expression
     */
    public function empty(): Query
    {
        return $this->where()->empty();
    }
}
