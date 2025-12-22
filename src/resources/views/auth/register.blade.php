<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>

    @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <div>
            <label>First Name:</label>
            <input type="text" name="firstname" value="{{ old('firstname') }}" required>
        </div>
        <div>
            <label>Last Name:</label>
            <input type="text" name="lastname" value="{{ old('lastname') }}" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label>Confirm Password:</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <div>
            <label>Role:</label>
            <select name="role" required>
                <option value="">--Select Role--</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div>
            <label>Position (for Users only):</label>
            <select name="position">
                <option value="">--Select Position--</option>
                <option value="employee">Employee</option>
                <option value="user">User</option>
                <option value="manager">Manager</option>
            </select>
        </div>
        <div>
            <button type="submit">Register</button>
        </div>
    </form>

    <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
</body>
</html>
