<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    /** @use HasFactory<Factory<self>> */
    use HasFactory;

    protected $fillable = ['user_id', 'module', 'file_path', 'original_name', 'status', 'score', 'feedback'];

    protected function casts(): array
    {
        return ['score' => 'decimal:2'];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
