<div class="p-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h1>
        <p class="text-gray-600 mt-1">Billing Dashboard</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">${{ number_format($stats['today_revenue'] ?? 0, 2) }}</div>
            <div class="text-sm text-gray-600 mt-1">Today's Revenue</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">${{ number_format($stats['monthly_revenue'] ?? 0, 2) }}</div>
            <div class="text-sm text-gray-600 mt-1">Monthly Revenue</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-orange-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['pending_bills'] ?? 0 }}</div>
            <div class="text-sm text-gray-600 mt-1">Pending Bills</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-red-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['overdue_bills'] ?? 0 }}</div>
            <div class="text-sm text-gray-600 mt-1">Overdue Bills</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-invoice text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['total_bills'] ?? 0 }}</div>
            <div class="text-sm text-gray-600 mt-1">Total Bills</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-teal-600 text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['paid_bills'] ?? 0 }}</div>
            <div class="text-sm text-gray-600 mt-1">Paid Bills</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('billing.create') }}" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <i class="fas fa-file-invoice-dollar text-blue-600 text-xl"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 group-hover:text-blue-600">Create Bill</div>
                    <div class="text-sm text-gray-600">Generate a new bill</div>
                </div>
            </div>
        </a>

        <a href="{{ route('billing.index') }}" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                    <i class="fas fa-list text-green-600 text-xl"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 group-hover:text-green-600">View All Bills</div>
                    <div class="text-sm text-gray-600">Manage all bills</div>
                </div>
            </div>
        </a>

        <a href="{{ route('reports.index') }}" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <i class="fas fa-chart-bar text-purple-600 text-xl"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 group-hover:text-purple-600">Financial Reports</div>
                    <div class="text-sm text-gray-600">View financial analytics</div>
                </div>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Pending Bills -->
        @if(isset($pendingBills) && $pendingBills->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Pending Bills</h2>
                        <p class="text-sm text-gray-600 mt-1">Bills awaiting payment</p>
                    </div>
                    <a href="{{ route('billing.index', ['status' => 'pending']) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        View All
                    </a>
                </div>
            </div>
            <div class="p-6 max-h-96 overflow-y-auto">
                <div class="space-y-3">
                    @foreach($pendingBills as $bill)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-file-invoice-dollar text-orange-600 text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-gray-900 text-sm truncate">{{ $bill->patient->name ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-600">
                                    <span class="font-mono">{{ $bill->bill_number ?? 'N/A' }}</span>
                                    @if($bill->due_date)
                                        <span class="mx-1">•</span>
                                        Due: {{ \Carbon\Carbon::parse($bill->due_date)->format('M d, Y') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 ml-2 flex-shrink-0">
                            <div class="text-right">
                                <div class="font-semibold text-gray-900 text-sm">${{ number_format($bill->total ?? 0, 2) }}</div>
                            </div>
                            <a href="{{ route('billing.show', $bill) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="text-center py-8">
                <i class="fas fa-check-circle text-gray-300 text-4xl mb-4"></i>
                <p class="text-gray-600">No pending bills</p>
            </div>
        </div>
        @endif

        <!-- Overdue Bills -->
        @if(isset($overdueBills) && $overdueBills->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Overdue Bills</h2>
                        <p class="text-sm text-gray-600 mt-1">Bills past due date</p>
                    </div>
                    <a href="{{ route('billing.index', ['status' => 'overdue']) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        View All
                    </a>
                </div>
            </div>
            <div class="p-6 max-h-96 overflow-y-auto">
                <div class="space-y-3">
                    @foreach($overdueBills as $bill)
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg hover:bg-red-100 transition-colors border border-red-200">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-red-600 text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-gray-900 text-sm truncate">{{ $bill->patient->name ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-600">
                                    <span class="font-mono">{{ $bill->bill_number ?? 'N/A' }}</span>
                                    @if($bill->due_date)
                                        <span class="mx-1">•</span>
                                        <span class="text-red-600 font-semibold">Due: {{ \Carbon\Carbon::parse($bill->due_date)->format('M d, Y') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 ml-2 flex-shrink-0">
                            <div class="text-right">
                                <div class="font-semibold text-gray-900 text-sm">${{ number_format($bill->total ?? 0, 2) }}</div>
                            </div>
                            <a href="{{ route('billing.show', $bill) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="text-center py-8">
                <i class="fas fa-check-circle text-gray-300 text-4xl mb-4"></i>
                <p class="text-gray-600">No overdue bills</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Recent Bills -->
    @if(isset($recentBills) && $recentBills->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Recent Bills</h2>
                    <p class="text-sm text-gray-600 mt-1">Latest bill transactions</p>
                </div>
                <a href="{{ route('billing.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    View All
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Bill Number</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Patient</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Date</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Amount</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBills as $bill)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4">
                                <span class="font-mono text-sm text-gray-900">{{ $bill->bill_number ?? 'N/A' }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-sm text-gray-900">{{ $bill->patient->name ?? 'N/A' }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-sm text-gray-600">
                                    {{ $bill->bill_date ? \Carbon\Carbon::parse($bill->bill_date)->format('M d, Y') : 'N/A' }}
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-semibold text-gray-900">${{ number_format($bill->total ?? 0, 2) }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ 
                                    $bill->status === 'paid' ? 'bg-green-100 text-green-800' :
                                    ($bill->status === 'pending' ? 'bg-orange-100 text-orange-800' :
                                    ($bill->status === 'overdue' ? 'bg-red-100 text-red-800' :
                                    ($bill->status === 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')))
                                }}">
                                    {{ ucfirst($bill->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('billing.show', $bill) }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
