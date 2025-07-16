<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Traits;

/**
 * Trait for handling field selection parameters.
 */
trait HasFieldParams
{
    /**
     * Set the fields to include in the response.
     *
     * @param  array<string>  $fields  Array of field names
     */
    public function withFields(array $fields): self
    {
        $this->query()->add('fields', implode(',', $fields));

        return $this;
    }
}
