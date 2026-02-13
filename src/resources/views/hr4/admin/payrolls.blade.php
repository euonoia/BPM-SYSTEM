@extends('layouts.hr4.app')

@section('title', 'Payrolls - HR4 Admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Payroll Records</h2>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Period</th>
                            <th>Payroll Date</th>
                            <th>Days Worked</th>
                            <th class="text-end">Net Pay</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payrolls as $p)
                        <tr>
                            <td>
                                @if($p->employee)
                                    {{ $p->employee->first_name }} {{ $p->employee->last_name }} ({{ $p->employee->employee_id }})
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{{ $p->payroll_period ?? '-' }}</td>
                            <td>{{ optional($p->payroll_date)->format('Y-m-d') }}</td>
                            <td>{{ $p->days_worked ?? 0 }}</td>
                            <td class="text-end">₱{{ number_format($p->net_pay ?? 0, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No payroll records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $payrolls->links() }}
        </div>
    </div>
</div>
@endsection
