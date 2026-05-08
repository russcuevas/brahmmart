<!DOCTYPE html>
<html>

<head>
    <style>
        .button {
            background-color: #752738;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 8px;
        }
    </style>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #2c3e50;">Welcome to Brahmmart, {{ $name }}!</h2>
        <p>Thank you for registering. To complete your account setup and start shopping, please verify your email
            address by clicking the button below:</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $url }}" class="button" style="color: white;">Verify Email Address</a>
        </div>

        <p>If you did not create an account, no further action is required.</p>
        <p>Regards,<br>Brahmmart Team</p>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #777;">If you're having trouble clicking the "Verify Email Address" button,
            copy and paste the URL below into your web browser: <br> {{ $url }}</p>
    </div>
</body>

</html>
