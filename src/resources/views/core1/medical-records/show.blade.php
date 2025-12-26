@extends('layouts.app')

@section('title', 'Medical Record Details')

@section('content')
<div class="p-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Medical Record</h1>
                <p class="text-gray-600 mt-1">View medical record details</p>
            </div>
            <a href="{{ route('medical-records.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                Back to List
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 max-w-3xl">
        <div class="space-y-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Patient</label>
                    <p class="text-gray-900 font-semibold">{{ $record->patient->name }}</p>
                    <p class="text-sm text-gray-500">{{ $record->patient->patient_id }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Doctor</label>
                    <p class="text-gray-900 font-semibold">{{ $record->doctor->name }}</p>
                    @if($record->doctor->specialization)
                        <p class="text-sm text-gray-500">{{ $record->doctor->specialization }}</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Record Type</label>
                    <p class="text-gray-900">{{ $record->record_type }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Record Date</label>
                    <p class="text-gray-900">{{ $record->record_date->format('M d, Y') }}</p>
                </div>
            </div>

            @if($record->diagnosis)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Diagnosis</label>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-900">{{ $record->diagnosis }}</p>
                </div>
            </div>
            @endif

            @if($record->treatment)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Treatment</label>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-900">{{ $record->treatment }}</p>
                </div>
            </div>
            @endif

            @if($record->prescription)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Prescription</label>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-900 whitespace-pre-line">{{ $record->prescription }}</p>
                </div>
            </div>
            @endif

            @if($record->notes)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-900">{{ $record->notes }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

