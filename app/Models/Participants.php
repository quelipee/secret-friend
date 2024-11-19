<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Participants extends Model
{
    use HasFactory, Notifiable, HasApiTokens, HasUuids;
    protected $table = 'participants';
    protected $fillable = [
        'name',
        'group_id',
        'user_id'
    ];

    public function groups(): HasMany
    {
        return $this->HasMany(Groups::class, 'id', 'group_id');
    }
}
