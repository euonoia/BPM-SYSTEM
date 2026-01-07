<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
</head>
<body>
    <h1>Edit Patient</h1>

    <!-- Validation errors -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('patients.update', $patient) }}">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ old('name', $patient->name) }}" required>
        <br>
        <input type="email" name="email" value="{{ old('email', $patient->email) }}" required>
        <br>
        <input type="text" name="phone" value="{{ old('phone', $patient->phone) }}">
        <br><br>
        <button type="submit">Update</button>
    </form>

    <br>
    <a href="{{ route('patients.index') }}">Back to Patients</a>
</body>
</html>
