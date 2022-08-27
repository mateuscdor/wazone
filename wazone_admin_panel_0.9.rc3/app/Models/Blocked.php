<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blocked extends Model
{

    protected $table = 'blocked';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
