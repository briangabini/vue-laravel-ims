<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SecurityQuestion extends Model
{
    /** @use HasFactory<\Database\Factories\SecurityQuestionFactory> */
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question_text',
    ];

    /**
     * Get the answers for the security question.
     */
    public function userSecurityAnswers(): HasMany
    {
        return $this->hasMany(UserSecurityAnswer::class);
    }
}
