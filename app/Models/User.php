<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'mobile_number',
        'email',
        'password',
        'user_role_id',
        'location_lat',
        'location_lng',
        'session_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function initials(int $limit = 2): string
    {
        $name = trim((string) ($this->name ?? ''));
        if ($name === '') return 'U';

        // Split by spaces and take first letters
        $parts = preg_split('/\s+/', $name, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $initials = '';

        foreach ($parts as $p) {
            $initials .= mb_strtoupper(mb_substr($p, 0, 1));
            if (mb_strlen($initials) >= $limit) break;
        }

        // If single word like "Aman", take first 2 letters
        if (mb_strlen($initials) < $limit) {
            $initials = mb_strtoupper(mb_substr($name, 0, $limit));
        }

        return $initials;
    }

    /* Relationships */

    public function role()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }

    /* Role helpers */

    public function isAdmin(): bool
    {
        return $this->user_role_id === 1;
    }

    public function isCustomer(): bool
    {
        return $this->user_role_id === 2;
    }

    public function isVendor(): bool
    {
        return in_array($this->user_role_id, [3, 4,5,6,7,8,14,15,16,17,18], true);
    }
}
