<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Miner extends Model
{
    use Notifiable;

    public function user() : BelongsTo
    {
        return $this->belongsTo( User::class);
    }

    public function workers() : HasMany
    {
        return $this->hasMany( Worker::class);
    }

    public function miners() : BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_miners');
    }
}
