<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>
</head>
<body>
    <h1>Add Patient</h1>

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

    <form method="POST" action="{{ route('patients.store') }}">
        @csrf
        <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
        <br>
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        <br>
        <input type="text" name="phone" placeholder="Phone" value="{{ old('phone') }}">
        <br><br>
        <button type="submit">Save</button>
    </form>

    <br>
    <a href="{{ route('patients.index') }}">Back to Patients</a>
</body>
</html>
