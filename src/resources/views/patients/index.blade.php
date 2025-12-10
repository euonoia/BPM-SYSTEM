<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients List</title>
</head>
<body>
    <h1>Patients</h1>

    <!-- Success message -->
    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add Patient Link -->
    <a href="{{ route('patients.create') }}">Add Patient</a>
    <br><br>

    <!-- Patient List -->
    @if($patients->isEmpty())
        <p>No patients yet. Click "Add Patient" to create one.</p>
    @else
        <ul>
            @foreach($patients as $patient)
                <li>
                    {{ $patient->name }} ({{ $patient->email }}) 
                    <a href="{{ route('patients.show', $patient) }}">View</a> |
                    <a href="{{ route('patients.edit', $patient) }}">Edit</a>
                    <form action="{{ route('patients.destroy', $patient) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this patient?')">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</body>
</html>
