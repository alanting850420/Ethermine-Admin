<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

class Group extends Model
{
    use Notifiable;

    public function miners() : BelongsToMany
    {
        return $this->belongsToMany(Miner::class, 'group_miners');
    }

}
