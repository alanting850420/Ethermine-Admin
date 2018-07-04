<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Worker extends Model
{
    use Notifiable;

    public function miner() : BelongsTo
    {
        return $this->belongsTo( Miner::class);
    }

}
