<?php

namespace App\DTOs;

use Illuminate\Support\Facades\Hash;

readonly class SupporterData
{
    public function __construct(
        public string $name,
        public string $email,
        public array $roles, // Array of role slugs
        public string $status,
        public ?string $phone = null,
        public ?string $password = null,
        public ?string $skills = null,
        public ?string $availability = null,
    ) {}

    /**
     * Create a DTO from an array (typically from a FormRequest)
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            roles: (array) ($data['roles'] ?? []),
            status: $data['status'],
            phone: $data['phone'] ?? null,
            password: $data['password'] ?? null,
            skills: $data['skills'] ?? null,
            availability: $data['availability'] ?? null,
        );
    }

    /**
     * Convert DTO to array for user creation/update
     */
    public function toUserArray(): array
    {
        $data = [
            'name'   => $this->name,
            'email'  => $this->email,
            'status' => $this->status,
            'phone'  => $this->phone,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        return $data;
    }

    /**
     * Convert DTO to array for profile creation/update
     */
    public function toProfileArray(): array
    {
        return [
            'skills'       => $this->skills,
            'availability' => $this->availability,
        ];
    }
}
