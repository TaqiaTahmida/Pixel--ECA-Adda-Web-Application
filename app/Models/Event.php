<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id', 'title', 'type', 'start_time', 'end_time', 'reminder', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
