<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MatchPair extends Model
{
    use HasFactory, HasApiTokens, Notifiable, HasUuids;
    protected $table = 'matches';
    protected $fillable = [
        'id',
        'group_id',
        'giver_id',
        'receiver_id'
    ];

    public function giver(): BelongsTo
    {
        return $this->belongsTo(Participants::class, 'giver_id');
    }
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Participants::class, 'receiver_id');
    }
}
