<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient</title>
</head>
<body>
    <h1>{{ $patient->name }}</h1>
    <p>Email: {{ $patient->email }}</p>
    <p>Phone: {{ $patient->phone }}</p>

    <a href="{{ route('patients.edit', $patient) }}">Edit</a> |
    <a href="{{ route('patients.index') }}">Back to Patients</a>
</body>
</html>
