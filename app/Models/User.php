<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'institution',
        'education_level',
        'package_type',
        'role',
        'payment_status',
        'registration_status',
        'otp_code',
        'otp_expires_at',
        'interests', // ✅ allow mass assignment of interests
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at'    => 'datetime',
        'interests'         => 'array', // ✅ automatically cast JSON to array
    ];

    public function ecaEnrollments()
{
    return $this->hasMany(\App\Models\EcaEnrollment::class);
}


    // ... existing code (fillable, hidden, casts, etc.)

    /**
     * Relationship: User has many chat messages
     */
    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    /**
     * Relationship: User has many admin messages
     */
    public function adminMessages()
    {
        return $this->hasMany(AdminMessage::class);
    }

    /**
     * Relationship: User has many achievements
     */
    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    /**
     * Relationship: User has many reactions
     */
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }


}
