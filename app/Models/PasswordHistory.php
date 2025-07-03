<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordHistory extends Model
{
    /** @use HasFactory<\Database\Factories\PasswordHistoryFactory> */
    use HasFactory;

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'password_hash',
    ];

    /**
     * Get the user that owns the password history record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
