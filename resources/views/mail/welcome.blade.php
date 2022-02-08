<!DOCTYPE html>
<html>
<head>
    <title>jake.com</title>
</head>
<body>
    <h1>註冊成功</h1>
    
    <p>歡迎</p>

    <a href="{{ env('MAIL_FOR_WELCOME') }}/daily?api_token={{ $token }}">Habit</a>
</body>
</html>