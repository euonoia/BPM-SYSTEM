@extends('core1.layouts.app')

@section('title', 'Medical Records')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Medical Records</h1>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Record Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($records as $record)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $record->patient->name }}</td>
                            <td class="px-6 py-4">{{ $record->record_type }}</td>
                            <td class="px-6 py-4">{{ $record->record_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('medical-records.show', $record) }}" class="text-blue-600 hover:text-blue-900">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">
        {{ $records->links() }}
    </div>
</div>
@endsection

