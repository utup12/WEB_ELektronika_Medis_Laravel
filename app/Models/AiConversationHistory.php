<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiConversationHistory extends Model
{
    public const LIMIT_PER_PERSON = 10;

    protected $fillable = [
        'owner_key',
        'user_id',
        'question',
        'answer',
        'sources',
    ];

    protected function casts(): array
    {
        return [
            'sources' => 'array',
        ];
    }
}
