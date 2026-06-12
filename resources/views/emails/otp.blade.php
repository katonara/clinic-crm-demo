<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="margin:0;background:#f1f5f9;font-family:Segoe UI,Helvetica,Arial,sans-serif;color:#334155;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding:32px 0;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:480px;background:#ffffff;border-radius:16px;overflow:hidden;border:1px solid #e2e8f0;">
                    <tr>
                        <td style="background:#2563eb;padding:24px 32px;color:#ffffff;font-size:18px;font-weight:700;">
                            ClinicCare
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 8px;font-size:18px;font-weight:600;color:#0f172a;">Verify your email</p>
                            <p style="margin:0 0 24px;font-size:14px;line-height:1.6;">
                                Hi {{ $user->name }}, use the one-time code below to verify your ClinicCare account.
                                This code expires in {{ \App\Services\OtpService::TTL_MINUTES }} minutes.
                            </p>
                            <div style="text-align:center;margin:0 0 24px;">
                                <span style="display:inline-block;background:#eff6ff;color:#1d4ed8;font-size:32px;font-weight:700;letter-spacing:8px;padding:16px 24px;border-radius:12px;">
                                    {{ $code }}
                                </span>
                            </div>
                            <p style="margin:0;font-size:12px;line-height:1.6;color:#94a3b8;">
                                If you didn't request this, you can safely ignore this email.
                            </p>
                        </td>
                    </tr>
                </table>
                <p style="max-width:480px;margin:16px auto 0;font-size:11px;color:#94a3b8;">
                    &copy; {{ date('Y') }} ClinicCare. All rights reserved.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
