<div class="p-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h1>
        <p class="text-gray-600 mt-1">Billing Dashboard</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="text-2xl font-bold text-gray-900">${{ number_format($todayRevenue, 2) }}</div>
            <div class="text-sm text-gray-600">Today's Revenue</div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="text-2xl font-bold text-gray-900">{{ $pendingBills }}</div>
            <div class="text-sm text-gray-600">Pending Bills</div>
        </div>
    </div>
</div>

