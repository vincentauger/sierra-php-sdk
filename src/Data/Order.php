<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Data;

use DateTimeImmutable;

/**
 * Sierra API Order DTO
 *
 * Represents an order/acquisition record
 */
final readonly class Order
{
    public function __construct(
        public int $id,
        public ?string $status = null,
        public ?DateTimeImmutable $orderDate = null,
        public ?string $vendor = null,
        public ?float $listPrice = null,
        public ?float $discountPercent = null,
        public ?int $copies = null,
        public ?string $fund = null,
        public ?string $location = null,
        public ?string $orderType = null,
        public ?string $note = null,
    ) {
    }

    /**
     * Create an Order from Sierra API response data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            status: $data['status'] ?? null,
            orderDate: isset($data['orderDate']) ? new DateTimeImmutable($data['orderDate']) : null,
            vendor: $data['vendor'] ?? null,
            listPrice: isset($data['listPrice']) ? (float) $data['listPrice'] : null,
            discountPercent: isset($data['discountPercent']) ? (float) $data['discountPercent'] : null,
            copies: $data['copies'] ?? null,
            fund: $data['fund'] ?? null,
            location: $data['location'] ?? null,
            orderType: $data['orderType'] ?? null,
            note: $data['note'] ?? null,
        );
    }

    /**
     * Convert the Order to an array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'orderDate' => $this->orderDate?->format('c'),
            'vendor' => $this->vendor,
            'listPrice' => $this->listPrice,
            'discountPercent' => $this->discountPercent,
            'copies' => $this->copies,
            'fund' => $this->fund,
            'location' => $this->location,
            'orderType' => $this->orderType,
            'note' => $this->note,
        ];
    }
}
