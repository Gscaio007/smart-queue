<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $subject }}</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4; color: #333333;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" max-width="600" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 30px;">
        <tr>
            <td>
                <h1 style="font-size: 24px; margin-bottom: 20px; color: #1a1a1a;">
                    {{ $subject }}
                </h1>
                
                <hr style="border: 0; border-top: 1px solid #eeeeee; margin-bottom: 20px;">

                <div style="font-size: 16px; line-height: 1.6; color: #555555;">
                    {!! nl2br(e($content)) !!}
                </div>

                <hr style="border: 0; border-top: 1px solid #eeeeee; margin-top: 30px; margin-bottom: 20px;">

                <p style="font-size: 12px; color: #999999; text-align: center; margin: 0;">
                    Este é um envio automático do sistema SmartQueue.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>