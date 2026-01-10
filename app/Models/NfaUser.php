<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property-read NfaUserProfile|null $profile  User profile (one-to-one)
 */
class NfaUser extends Model
{
    use HasFactory;
        use HasApiTokens, Notifiable;


    protected $table = 'nfa_users';

    protected $fillable = [
        'name',
        'email',
        'cnic',
        'number',
        'password',
        'is_blocked',
        'blocked_at'
    ];

    protected $hidden = [
        'password'
    ];
      protected $casts = [
        'blocked_at' => 'datetime',
    ];
    // One-to-one relationship with profile
    public function profile()
{
    return $this->hasOne(NfaUserProfile::class, 'nfa_user_id', 'id');
}

}
