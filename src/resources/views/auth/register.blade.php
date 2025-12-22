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
            <input type="text" name="first_name" value="{{ old('first_name') }}" required>
        </div>
        <div>
            <label>Last Name:</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}" required>
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
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="hr" {{ old('role') == 'hr' ? 'selected' : '' }}>HR</option>
                <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
            </select>
        </div>
        <div>
            <label>Position (optional):</label>
            <select name="position">
                <option value="">--Select Position--</option>
                <option value="employee" {{ old('position') == 'employee' ? 'selected' : '' }}>Employee</option>
                <option value="user" {{ old('position') == 'user' ? 'selected' : '' }}>User</option>
                <option value="manager" {{ old('position') == 'manager' ? 'selected' : '' }}>Manager</option>
            </select>
        </div>
        <div>
            <label>Branch (optional):</label>
            <input type="text" name="branch" value="{{ old('branch') }}">
        </div>
        <div>
            <label>Hire Date (optional):</label>
            <input type="date" name="hire_date" value="{{ old('hire_date') }}">
        </div>
        <div>
            <button type="submit">Register</button>
        </div>
    </form>

    <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
</body>
</html>
