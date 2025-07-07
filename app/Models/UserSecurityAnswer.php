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
        'answer',
    ];

    /**
     * Set the user's answer.
     *
     * @param  string  $value
     * @return void
     */
    public function setAnswerAttribute(string $value): void
    {
        $this->attributes['answer_hash'] = bcrypt($value);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Get the user's answer.
     *
     * @return string
     */
    public function getAnswerAttribute(): string
    {
        return ''; // We don't return the actual answer for security reasons
    }

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
