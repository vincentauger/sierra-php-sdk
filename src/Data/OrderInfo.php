<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

/**
 * Sierra API Order Info DTO
 *
 * Represents order information for a bibliographic record
 */
final readonly class OrderInfo
{
    public function __construct(
        public string $orderId,
        public Location $location,
        public int $copies,
        public ?string $date = null,
    ) {}

    /**
     * Create an OrderInfo from Sierra API response data
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            orderId: $data['orderId'],
            location: Location::fromArray($data['location']),
            copies: $data['copies'],
            date: $data['date'] ?? null,
        );
    }

    /**
     * Convert the OrderInfo to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'orderId' => $this->orderId,
            'location' => $this->location->toArray(),
            'copies' => $this->copies,
            'date' => $this->date,
        ];
    }
}
