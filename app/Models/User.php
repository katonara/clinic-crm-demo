<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Database\Factories\UserFactory;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmailContract
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, MustVerifyEmail, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'whatsapp',
        'role',
        'password',
        'email_verified_at',
        'email_otp',
        'email_otp_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_otp',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'email_otp_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Appointments belonging to this user.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Whether the user is a clinic staff/admin member.
     */
    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    /**
     * Build a click-to-chat WhatsApp deep link for this user.
     * Uses the WhatsApp number when set, otherwise falls back to the phone.
     * Returns null when no usable number is on file.
     */
    public function whatsappUrl(string $message = ''): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) ($this->whatsapp ?: $this->phone));

        if (blank($digits)) {
            return null;
        }

        $url = 'https://wa.me/' . $digits;

        return $message !== '' ? $url . '?text=' . rawurlencode($message) : $url;
    }
}
