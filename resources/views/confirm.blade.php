<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Confirmation</title>
</head>
<body>
    <h1>Confirm Your Email Address</h1>
    <p>Hello {{ $user->name }},</p>
    <p>Please use the following verification code to confirm your email address:</p>
    <p>Verification Code: {{ $user->verification_code }}</p>
    <p>If you didn't request this verification, you can safely ignore this email.</p>
    <p>Thank you!</p></body>
</html>