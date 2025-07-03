<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSecurityAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\UserSecurityAnswerFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'security_question_id',
        'answer_hash',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'answer_hash',
    ];

    /**
     * Get the user that owns the security answer.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the security question associated with the answer.
     */
    public function securityQuestion(): BelongsTo
    {
        return $this->belongsTo(SecurityQuestion::class);
    }
}
