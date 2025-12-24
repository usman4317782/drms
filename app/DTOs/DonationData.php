<?php

namespace App\DTOs;

use App\Enums\DonationType;
use App\Enums\DonationStatus;

readonly class DonationData
{
    public function __construct(
        public int $supporter_id,
        public DonationType $type,
        public string $description,
        public DonationStatus $status = DonationStatus::SUBMITTED,
        public ?int $camp_id = null,
        public ?float $amount = null,
        public ?int $quantity = null,
        public ?string $unit = null,
    ) {}

    /**
     * Create a DTO from an array (typically from a FormRequest).
     */
    public static function fromArray(array $data, int $supporterId): self
    {
        return new self(
            supporter_id: $supporterId,
            type: $data['type'] instanceof DonationType ? $data['type'] : DonationType::from($data['type']),
            description: $data['description'],
            status: isset($data['status']) 
                ? ($data['status'] instanceof DonationStatus ? $data['status'] : DonationStatus::from($data['status'])) 
                : DonationStatus::SUBMITTED,
            camp_id: $data['camp_id'] ?? null,
            amount: isset($data['amount']) ? (float) $data['amount'] : null,
            quantity: isset($data['quantity']) ? (int) $data['quantity'] : null,
            unit: $data['unit'] ?? null,
        );
    }

    /**
     * Convert DTO to array for model creation.
     */
    public function toArray(): array
    {
        return [
            'supporter_id' => $this->supporter_id,
            'camp_id' => $this->camp_id,
            'type' => $this->type->value,
            'status' => $this->status->value,
            'amount' => $this->amount,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'description' => $this->description,
        ];
    }
}
