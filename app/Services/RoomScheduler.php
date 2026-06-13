<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Room;

/**
 * Capacity-aware scheduling: a time slot can hold as many concurrent
 * appointments as there are active treatment rooms. Each booking is
 * auto-assigned to a free room for its slot.
 */
class RoomScheduler
{
    /**
     * Clinic operating sessions: 10am to 6pm, one-hour gaps.
     */
    public const SLOTS = [
        '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00',
    ];

    public function activeRoomCount(): int
    {
        return Room::active()->count();
    }

    /**
     * Non-cancelled appointments occupying a given date + time.
     */
    private function occupying(string $date, string $time, ?int $ignoreId = null)
    {
        return Appointment::query()
            ->whereDate('appointment_date', $date)
            ->where('appointment_time', $time)
            ->where('status', '!=', 'cancelled')
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId));
    }

    public function isSlotFull(string $date, string $time, ?int $ignoreId = null): bool
    {
        return $this->occupying($date, $time, $ignoreId)->count() >= $this->activeRoomCount();
    }

    /**
     * Return an available active room id for a slot, or null when the slot is full.
     */
    public function freeRoomId(string $date, string $time, ?int $ignoreId = null): ?int
    {
        $roomIds = Room::active()->orderBy('id')->pluck('id');

        if ($roomIds->isEmpty()) {
            return null;
        }

        $occupied = $this->occupying($date, $time, $ignoreId)->get();

        // Capacity is bounded by the number of active rooms (handles legacy null-room rows).
        if ($occupied->count() >= $roomIds->count()) {
            return null;
        }

        $takenRoomIds = $occupied->pluck('room_id')->filter()->all();

        return $roomIds->first(fn ($id) => ! in_array($id, $takenRoomIds, true)) ?? $roomIds->first();
    }

    /**
     * Slots (from SLOTS) that are fully booked for a date — used to grey out the picker.
     * Also marks past times when the date is today.
     */
    public function fullSlots(string $date, ?int $ignoreId = null): array
    {
        $roomCount = $this->activeRoomCount();

        $counts = Appointment::query()
            ->whereDate('appointment_date', $date)
            ->where('status', '!=', 'cancelled')
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->selectRaw('appointment_time, COUNT(*) as c')
            ->groupBy('appointment_time')
            ->pluck('c', 'appointment_time');

        $full = [];
        foreach (self::SLOTS as $slot) {
            if (($counts[$slot] ?? 0) >= $roomCount) {
                $full[] = $slot;
            }
        }

        if ($date === now()->toDateString()) {
            $nowTime = now()->format('H:i');
            foreach (self::SLOTS as $slot) {
                if ($slot <= $nowTime) {
                    $full[] = $slot;
                }
            }
        }

        return array_values(array_unique($full));
    }
}
