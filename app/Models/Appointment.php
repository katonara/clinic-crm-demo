<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    public const STATUSES = ['pending', 'confirmed', 'completed', 'cancelled'];

    protected $fillable = [
        'user_id',
        'service_id',
        'room_id',
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Tailwind badge classes per status.
     */
    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'confirmed' => 'bg-green-50 text-green-700',
            'completed' => 'bg-brand-50 text-brand-700',
            'cancelled' => 'bg-rose-50 text-rose-700',
            default => 'bg-amber-50 text-amber-700', // pending
        };
    }
}
