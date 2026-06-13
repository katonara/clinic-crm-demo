@php
    $messages = [
        'booked' => 'We have received your appointment request. Our staff will review and confirm it shortly.',
        'confirmed' => 'Good news! Your appointment has been confirmed. We look forward to seeing you.',
        'completed' => 'Your appointment is marked as completed. Thank you for choosing ClinicCare.',
        'cancelled' => 'Your appointment has been cancelled. You may book a new appointment anytime.',
        'reminder' => 'This is a friendly reminder about your upcoming appointment tomorrow.',
    ];
    $heading = [
        'booked' => 'Appointment requested',
        'confirmed' => 'Appointment confirmed',
        'completed' => 'Appointment completed',
        'cancelled' => 'Appointment cancelled',
        'reminder' => 'Appointment reminder',
    ];
    $accent = $kind === 'cancelled' ? '#e11d48' : ($kind === 'confirmed' ? '#16a34a' : '#2563eb');
@endphp
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body style="margin:0;background:#f1f5f9;font-family:Segoe UI,Helvetica,Arial,sans-serif;color:#334155;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding:32px 0;">
        <tr><td align="center">
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:520px;background:#ffffff;border-radius:16px;overflow:hidden;border:1px solid #e2e8f0;">
                <tr><td style="background:#2563eb;padding:24px 32px;color:#ffffff;font-size:18px;font-weight:700;">ClinicCare</td></tr>
                <tr><td style="padding:32px;">
                    <p style="margin:0 0 8px;font-size:18px;font-weight:600;color:{{ $accent }};">{{ $heading[$kind] ?? 'Appointment update' }}</p>
                    <p style="margin:0 0 20px;font-size:14px;line-height:1.6;">
                        Hi {{ $appointment->user->name }}, {{ $messages[$kind] ?? 'There is an update to your appointment.' }}
                    </p>

                    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border-radius:12px;padding:8px 0;">
                        <tr><td style="padding:12px 20px;font-size:14px;">
                            <strong style="color:#0f172a;">Service:</strong> {{ $appointment->service->name }}<br>
                            <strong style="color:#0f172a;">Date:</strong> {{ $appointment->appointment_date->format('l, d M Y') }}<br>
                            <strong style="color:#0f172a;">Time:</strong> {{ $appointment->appointment_time }}<br>
                            <strong style="color:#0f172a;">Status:</strong> <span style="text-transform:capitalize;">{{ $appointment->status }}</span>
                        </td></tr>
                    </table>

                    <p style="margin:24px 0 0;">
                        <a href="{{ url('/dashboard') }}" style="display:inline-block;background:#2563eb;color:#ffffff;text-decoration:none;font-size:14px;font-weight:600;padding:12px 20px;border-radius:10px;">
                            View my appointments
                        </a>
                    </p>
                </td></tr>
            </table>
            <p style="max-width:520px;margin:16px auto 0;font-size:11px;color:#94a3b8;">&copy; {{ date('Y') }} ClinicCare. All rights reserved.</p>
        </td></tr>
    </table>
</body>
</html>
