<?php

namespace App\DTOs;

readonly class TaskData
{
    public function __construct(
        public int $camp_id,
        public int $manager_id,
        public ?int $assigned_to,
        public string $title,
        public ?string $description = null,
        public ?string $required_skills = null,
        public string $status = 'pending',
        public string $priority = 'medium',
        public ?string $due_date = null,
    ) {}

    /**
     * Create DTO from array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            camp_id: (int) $data['camp_id'],
            manager_id: (int) (auth()->id()),
            assigned_to: isset($data['assigned_to']) && $data['assigned_to'] !== "" ? (int) $data['assigned_to'] : null,
            title: $data['title'],
            description: $data['description'] ?? null,
            required_skills: $data['required_skills'] ?? null,
            status: $data['status'] ?? 'pending',
            priority: $data['priority'] ?? 'medium',
            due_date: $data['due_date'] ?? null,
        );
    }

    /**
     * Convert to array for database insertion/update.
     */
    public function toArray(): array
    {
        return [
            'camp_id' => $this->camp_id,
            'manager_id' => $this->manager_id,
            'assigned_to' => $this->assigned_to,
            'title' => $this->title,
            'description' => $this->description,
            'required_skills' => $this->required_skills,
            'status' => $this->status,
            'priority' => $this->priority,
            'due_date' => $this->due_date,
        ];
    }
}
