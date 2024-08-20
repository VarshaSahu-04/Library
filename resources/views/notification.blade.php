<!DOCTYPE html>
<html>
<head>
    <title>Overdue Rental Notification</title>
</head>
<body>
    <p>Dear {{ $rental->name }},</p>
    <p>Your rental for the book "{{ $rental->title }}" is overdue. Please return it as soon as possible.</p>
    <p>Thank you!</p>
</body>
</html>