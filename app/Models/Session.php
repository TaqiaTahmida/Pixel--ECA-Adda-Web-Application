<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'event_uuid',
        'user_id',
        'invitee_email',
        'status',
        'start_time',
        'end_time',
    ];

    protected $dates = ['start_time', 'end_time'];
}
?>