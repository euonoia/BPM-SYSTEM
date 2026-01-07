@extends('layouts.hr2.admin.app')

@section('title', 'Succession Planning - HR2 Admin')

@section('content')
<div class="container">
    <h2>Succession Planning</h2>

    <!-- Add Position -->
    <form method="POST" action="{{ route('admin.succession.storePosition') }}">
        @csrf
        <h3>Add New Position</h3>
        <input type="text" name="position_title" placeholder="Position Title" required>
        <label>Criticality:</label>
        <select name="criticality" required>
            <option value="low">Low</option>
            <option value="medium" selected>Medium</option>
            <option value="high">High</option>
        </select>
        <button type="submit">Add Position</button>
    </form>

    <!-- Positions Table -->
    <h3 class="section-title">Succession Positions</h3>
    <table>
        <thead>
            <tr>
                <th>Position Title</th>
                <th>Branch ID</th>
                <th>Criticality</th>
                <th>Candidates</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($positions as $p)
                <tr>
                    <td>{{ $p->position_title }}</td>
                    <td>{{ $p->branch_id }}</td>
                    <td>{{ ucfirst($p->criticality) }}</td>
                    <td>{{ $p->candidates_count }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.succession.destroyPosition', $p->id) }}" onsubmit="return confirm('Archive this position?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-del">Archive</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;">No positions found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Add Candidate -->
    <form method="POST" action="{{ route('admin.succession.storeCandidate') }}" style="margin-top:40px;">
        @csrf
        <h3>Add Candidate to Position</h3>

        <label>Position:</label>
        <select name="position_id" required>
            <option value="">-- Select Position --</option>
            @foreach($positions as $p)
                <option value="{{ $p->branch_id }}">{{ $p->position_title }}</option>
            @endforeach
        </select>

        <label>Employee:</label>
        <select name="employee_id" required>
            <option value="">-- Select Employee --</option>
            @foreach($employees as $e)
                <option value="{{ $e->employee_id }}">{{ $e->first_name }} {{ $e->last_name }} ({{ $e->employee_id }})</option>
            @endforeach
        </select>

        <label>Readiness:</label>
        <select name="readiness" required>
            <option value="ready">Ready</option>
            <option value="not_ready">Not Ready</option>
        </select>

        <label>Effective At:</label>
        <input type="date" name="effective_at" required>

        <textarea name="development_plan" placeholder="Development Plan (optional)"></textarea>
        <button type="submit">Add Candidate</button>
    </form>

    <!-- Candidates Table -->
    <h3 class="section-title">Succession Candidates</h3>
    <table>
        <thead>
            <tr>
                <th>Position</th>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>Readiness</th>
                <th>Effective At</th>
                <th>Development Plan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($candidates as $c)
                <tr>
                    <td>{{ $c->position->position_title }}</td>
                    <td>{{ $c->employee->first_name }} {{ $c->employee->last_name }}</td>
                    <td>{{ $c->employee_id }}</td>
                    <td>{{ ucfirst($c->readiness) }}</td>
                    <td>{{ $c->effective_at }}</td>
                    <td>{{ $c->development_plan }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.succession.destroyCandidate', $c->id) }}" onsubmit="return confirm('Archive this candidate?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-del">Archive</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;">No candidates found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
