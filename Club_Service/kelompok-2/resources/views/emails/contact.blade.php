<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pesan Baru dari Form Kontak</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <tr>
            <td style="background-color: #ff0404; color: #ffffff; padding: 20px; text-align: center;">
                <h2 style="margin: 0;">Pesan Baru dari Form Kontak</h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <p><strong>Nama:</strong> {{ $data['name'] }}</p>
                <p><strong>Email:</strong> {{ $data['email'] }}</p>
                <p><strong>Subject:</strong> {{ $data['subject'] }}</p>
                <p><strong>Pesan:</strong></p>
                <p style="background: #f1f1f1; padding: 10px; border-radius: 5px;">{{ $data['message'] }}</p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #f8f9fa; text-align: center; padding: 15px; font-size: 12px; color: #888;">
                &copy; {{ date('Y') }} Porlempika. All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>
