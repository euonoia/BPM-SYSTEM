<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
        
    <h1>CORE</h1>

   <form action="{{ route('core.login.post') }}" method="POST">
    @csrf
    <input type="email" name="email" required>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
</form>


    <p>Don't have an account? <a href="{{ route('core.register') }}">Register here</a></p>
</body>
</html>
