<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Groups extends Model
{
    use HasFactory, HasApiTokens, HasUuids;
    protected $table = 'groups';
    protected $fillable = [
        'name'
    ];

    public function participants()
    {
        return $this->hasMany(Participants::class, 'group_id');
    }
}
