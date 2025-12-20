<?php

namespace App\DTOs;

use Illuminate\Support\Facades\Hash;

readonly class UserData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $role,
        public string $status,
        public ?string $phone = null,
        public ?string $password = null,
    ) {}

    /**
     * Create a DTO from an array (typically from a FormRequest)
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            role: $data['role'],
            status: $data['status'],
            phone: $data['phone'] ?? null,
            password: $data['password'] ?? null,
        );
    }

    /**
     * Convert DTO to array for model creation/update
     */
    public function toArray(): array
    {
        $data = [
            'name'   => $this->name,
            'email'  => $this->email,
            'role'   => $this->role,
            'status' => $this->status,
            'phone'  => $this->phone,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        return $data;
    }
}
