<?php

namespace App\Models;

use App\Enums\DonationStatus;
use App\Enums\DonationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supporter_id',
        'camp_id',
        'type',
        'status',
        'amount',
        'quantity',
        'unit',
        'description',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => DonationType::class,
            'status' => DonationStatus::class,
            'amount' => 'decimal:2',
        ];
    }

    /**
     * The supporter who made the donation.
     */
    public function supporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supporter_id');
    }

    /**
     * The camp this donation is assigned to.
     */
    public function camp(): BelongsTo
    {
        return $this->belongsTo(Camp::class);
    }

    /**
     * Get the status color for UI display.
     */
    public function getStatusColorAttribute(): string
    {
        return $this->status->color();
    }

    /**
     * Get the type label for UI display.
     */
    public function getTypeLabelAttribute(): string
    {
        return $this->type->label();
    }
}
