<?php

namespace App\DTOs;

readonly class CampData
{
    public function __construct(
        public string $name,
        public string $district,
        public string $location,
        public int $capacity,
        public string $status,
        public ?int $manager_id = null,
        public array $facilities = [],
    ) {}

    /**
     * Create a DTO from an array (typically from a FormRequest)
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            district: $data['district'],
            location: $data['location'],
            capacity: (int) $data['capacity'],
            status: $data['status'],
            manager_id: isset($data['manager_id']) ? (int) $data['manager_id'] : null,
            facilities: $data['facilities'] ?? [],
        );
    }

    /**
     * Convert DTO to array for model creation/update
     */
    public function toArray(): array
    {
        return [
            'name'       => $this->name,
            'district'   => $this->district,
            'location'   => $this->location,
            'capacity'   => $this->capacity,
            'status'     => $this->status,
            'manager_id' => $this->manager_id,
            'facilities' => $this->facilities,
        ];
    }
}
