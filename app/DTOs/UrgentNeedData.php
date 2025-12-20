<?php

namespace App\DTOs;

readonly class UrgentNeedData
{
    public function __construct(
        public string $priority,
        public string $status,
    ) {}

    /**
     * Create a DTO from an array (typically from a FormRequest)
     */
    public static function fromArray(array $data): self
    {
        return new self(
            priority: $data['priority'],
            status: $data['status'],
        );
    }

    /**
     * Convert DTO to array for model creation/update
     */
    public function toArray(): array
    {
        return [
            'priority' => $this->priority,
            'status'   => $this->status,
        ];
    }
}
