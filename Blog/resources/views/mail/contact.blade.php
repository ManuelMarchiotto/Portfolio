<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Hai ricevuto un nuovo contatto da {{ config('app.name') }}!
    <br>
    <br>
    Nome: {{ $name }}<br>
    Email: {{ $email }}<br>
    Messaggio: {{ $content }}
</body>
</html>