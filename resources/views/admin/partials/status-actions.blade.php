@php
    // Allowed quick transitions per current status.
    $actions = match ($appointment->status) {
        'pending' => [['confirmed', 'Confirm', 'green'], ['cancelled', 'Cancel', 'rose']],
        'confirmed' => [['completed', 'Complete', 'brand'], ['cancelled', 'Cancel', 'rose']],
        default => [],
    };
@endphp

@if ($actions)
    <div class="flex items-center gap-1.5">
        @foreach ($actions as [$status, $label, $color])
            <form method="POST" action="{{ route('admin.appointments.status', $appointment) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="{{ $status }}">
                <button type="submit" @class([
                    'rounded-lg px-2.5 py-1 text-xs font-semibold transition',
                    'bg-green-50 text-green-700 hover:bg-green-100' => $color === 'green',
                    'bg-brand-50 text-brand-700 hover:bg-brand-100' => $color === 'brand',
                    'bg-rose-50 text-rose-700 hover:bg-rose-100' => $color === 'rose',
                ])>{{ $label }}</button>
            </form>
        @endforeach
    </div>
@endif
