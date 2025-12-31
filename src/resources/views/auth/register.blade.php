<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .error-message {
            color: red;
            background: #ffe6e6;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .error-message ul {
            margin: 0;
            padding-left: 20px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .subsystem-fields {
            display: none;
        }
        .subsystem-fields.active {
            display: block;
        }
        .link {
            margin-top: 20px;
            text-align: center;
        }
        .link a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>

        @if($errors->any())
            <div class="error-message">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" id="registerForm">
            @csrf
            
            <div class="form-group">
                <label>Subsystem:</label>
                <select name="subsystem" id="subsystem" required onchange="toggleSubsystemFields()">
                    <option value="">--Select Subsystem--</option>
                    <option value="hr" {{ old('subsystem') == 'hr' ? 'selected' : '' }}>HR System</option>
                    <option value="core1" {{ old('subsystem') == 'core1' ? 'selected' : '' }}>Core1 System (Hospital Management)</option>
                </select>
            </div>

            <!-- Core1 System Name Field -->
            <div class="form-group core1-fields subsystem-fields" id="core1-name-field">
                <label>Name:</label>
                <input type="text" name="name" value="{{ old('name') }}">
            </div>

            <!-- HR System Name Fields -->
            <div class="form-group hr-fields subsystem-fields" id="hr-name-fields">
                <label>First Name:</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}">
            </div>

            <div class="form-group hr-fields subsystem-fields" id="hr-last-name-field">
                <label>Last Name:</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}">
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password:</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <!-- HR System Roles -->
            <div class="form-group hr-fields subsystem-fields" id="hr-role-fields">
                <label>Role:</label>
                <select name="role" id="hr-role">
                    <option value="">--Select Role--</option>
                    <option value="hr" {{ old('role') == 'hr' ? 'selected' : '' }}>HR</option>
                    <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                </select>
            </div>

            <!-- Core1 System Roles -->
            <div class="form-group core1-fields subsystem-fields" id="core1-role-fields">
                <label>Role:</label>
                <select name="role" id="core1-role">
                    <option value="">--Select Role--</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                    <option value="doctor" {{ old('role') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                    <option value="nurse" {{ old('role') == 'nurse' ? 'selected' : '' }}>Nurse</option>
                    <option value="receptionist" {{ old('role') == 'receptionist' ? 'selected' : '' }}>Receptionist</option>
                    <option value="patient" {{ old('role') == 'patient' ? 'selected' : '' }}>Patient</option>
                    <option value="billing" {{ old('role') == 'billing' ? 'selected' : '' }}>Billing Officer</option>
                </select>
            </div>

            <!-- HR System Optional Fields -->
            <div class="form-group hr-fields subsystem-fields" id="hr-optional-fields">
                <label>Position (optional):</label>
                <select name="position">
                    <option value="">--Select Position--</option>
                    <option value="employee" {{ old('position') == 'employee' ? 'selected' : '' }}>Employee</option>
                    <option value="user" {{ old('position') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="manager" {{ old('position') == 'manager' ? 'selected' : '' }}>Manager</option>
                </select>
            </div>

            <div class="form-group hr-fields subsystem-fields" id="hr-branch-field">
                <label>Branch (optional):</label>
                <input type="text" name="branch" value="{{ old('branch') }}">
            </div>

            <div class="form-group hr-fields subsystem-fields" id="hr-hire-date-field">
                <label>Hire Date (optional):</label>
                <input type="date" name="hire_date" value="{{ old('hire_date') }}">
            </div>

            <!-- Core1 System Optional Fields -->
            <div class="form-group core1-fields subsystem-fields" id="core1-optional-fields">
                <label>Phone (optional):</label>
                <input type="text" name="phone" value="{{ old('phone') }}">
            </div>

            <div class="form-group core1-fields subsystem-fields" id="core1-department-field">
                <label>Department (optional):</label>
                <input type="text" name="department" value="{{ old('department') }}">
            </div>

            <div class="form-group core1-fields subsystem-fields" id="core1-specialization-field">
                <label>Specialization (optional):</label>
                <input type="text" name="specialization" value="{{ old('specialization') }}">
            </div>

            <div class="form-group">
                <button type="submit">Register</button>
            </div>
        </form>

        <div class="link">
            <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
        </div>
    </div>

    <script>
        function toggleSubsystemFields() {
            const subsystem = document.getElementById('subsystem').value;
            const hrFields = document.querySelectorAll('.hr-fields');
            const core1Fields = document.querySelectorAll('.core1-fields');
            const hrRoleField = document.getElementById('hr-role');
            const core1RoleField = document.getElementById('core1-role');
            
            // Hide all subsystem-specific fields
            hrFields.forEach(field => {
                if (field.classList.contains('subsystem-fields')) {
                    field.classList.remove('active');
                }
            });
            core1Fields.forEach(field => {
                if (field.classList.contains('subsystem-fields')) {
                    field.classList.remove('active');
                }
            });
            
            // Show relevant fields based on subsystem
            if (subsystem === 'hr') {
                hrFields.forEach(field => {
                    if (field.classList.contains('subsystem-fields')) {
                        field.classList.add('active');
                    }
                });
                hrRoleField.required = true;
                core1RoleField.required = false;
                core1RoleField.value = '';
                // Set required for HR fields
                document.querySelector('input[name="first_name"]').required = true;
                document.querySelector('input[name="last_name"]').required = true;
                const core1NameField = document.querySelector('input[name="name"]');
                if (core1NameField) core1NameField.required = false;
            } else if (subsystem === 'core1') {
                core1Fields.forEach(field => {
                    if (field.classList.contains('subsystem-fields')) {
                        field.classList.add('active');
                    }
                });
                core1RoleField.required = true;
                hrRoleField.required = false;
                hrRoleField.value = '';
                // Set required for Core1 fields
                const core1NameField = document.querySelector('input[name="name"]');
                if (core1NameField) core1NameField.required = true;
                document.querySelector('input[name="first_name"]').required = false;
                document.querySelector('input[name="last_name"]').required = false;
            } else {
                hrRoleField.required = false;
                core1RoleField.required = false;
                document.querySelector('input[name="first_name"]').required = false;
                document.querySelector('input[name="last_name"]').required = false;
                const core1NameField = document.querySelector('input[name="name"]');
                if (core1NameField) core1NameField.required = false;
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleSubsystemFields();
        });
    </script>
</body>
</html>
