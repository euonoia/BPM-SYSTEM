<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login — HR2</title>
<style>
body{font-family:Arial,sans-serif;background:#f3f4f6;margin:0;display:flex;align-items:center;justify-content:center;min-height:100vh}
.card{background:#fff;padding:28px;border-radius:10px;box-shadow:0 10px 30px rgba(0,0,0,.08);width:360px}
h2{margin:0 0 12px;font-size:20px}
input{width:100%;padding:10px;margin:8px 0;border-radius:6px;border:1px solid #ccc;box-sizing:border-box}
button{width:100%;padding:10px;border-radius:6px;border:0;background:#2563eb;color:#fff;font-weight:600;cursor:pointer}
.msg{margin:12px 0;padding:10px;border-radius:6px;background:#fee2e2;color:#b91c1c}
label{font-size:13px;color:#333;display:block;margin-top:6px}
</style>
</head>
<body>
<div class="card">
    <h2>Admin Login</h2>
    @if($errors->any())
        <div class="msg">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('hr.hr2.admin.login.submit') }}">
        @csrf
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required value="{{ old('email') }}">

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>

        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
