<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR2 Page</title>
</head>
<body>
    <h1>Welcome to HR2</h1>
    
    <!-- Link to HR2 page itself -->
    <a href="{{ route('hr2') }}">Go to HR2 Index</a>
    <br>

    <!-- Link to Patients CRUD index page -->
    <a href="{{ route('patients.index') }}">Go to Patients</a>
</body>
</html>
