<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $skills
 * @property string|null $availability
 */
class SupporterProfile extends Model
{
    protected $fillable = [
        'user_id',
        'skills',
        'availability',
    ];

    /**
     * User associated with this profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
