<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hospital Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-md">
        <div class="flex items-center justify-center mb-8">
            <i class="fas fa-hospital text-blue-600 text-3xl mr-3"></i>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">HMS Portal</h1>
                <p class="text-sm text-gray-600">Hospital Management System</p>
            </div>
        </div>

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Select Role
                </label>
                <div class="grid grid-cols-2 gap-3">
                    @php
                        $roles = [
                            ['value' => 'admin', 'label' => 'Administrator', 'color' => 'bg-purple-500'],
                            ['value' => 'doctor', 'label' => 'Doctor', 'color' => 'bg-blue-500'],
                            ['value' => 'nurse', 'label' => 'Nurse', 'color' => 'bg-green-500'],
                            ['value' => 'patient', 'label' => 'Patient', 'color' => 'bg-orange-500'],
                            ['value' => 'receptionist', 'label' => 'Receptionist', 'color' => 'bg-pink-500'],
                            ['value' => 'billing', 'label' => 'Billing Officer', 'color' => 'bg-teal-500'],
                        ];
                    @endphp
                    @foreach($roles as $role)
                        <button
                            type="button"
                            onclick="document.getElementById('role').value='{{ $role['value'] }}'; updateRoleSelection('{{ $role['value'] }}');"
                            class="role-btn p-3 rounded-lg border-2 transition-all bg-white text-gray-700 border-gray-200 hover:border-gray-300"
                            data-role="{{ $role['value'] }}"
                            data-color="{{ $role['color'] }}"
                        >
                            {{ $role['label'] }}
                        </button>
                    @endforeach
                </div>
                <input type="hidden" name="role" id="role" value="admin" required>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                    placeholder="Enter your email"
                    required
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                    placeholder="Enter your password"
                    required
                >
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2"
            >
                <i class="fas fa-sign-in-alt"></i>
                Sign In
            </button>
        </form>

        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <p class="text-xs text-blue-800 text-center">
                Demo Mode: Select any role and click Sign In to access the dashboard
            </p>
        </div>
    </div>

    <script>
        function updateRoleSelection(selectedRole) {
            document.querySelectorAll('.role-btn').forEach(btn => {
                const role = btn.getAttribute('data-role');
                const color = btn.getAttribute('data-color');
                if (role === selectedRole) {
                    btn.classList.remove('bg-white', 'text-gray-700', 'border-gray-200');
                    btn.classList.add(color, 'text-white', 'border-transparent');
                } else {
                    btn.classList.remove(color, 'text-white', 'border-transparent');
                    btn.classList.add('bg-white', 'text-gray-700', 'border-gray-200');
                }
            });
        }
        
        // Initialize with admin selected
        updateRoleSelection('admin');
    </script>
</body>
</html>

