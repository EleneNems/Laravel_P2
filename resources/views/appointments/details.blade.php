<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Appointment Details</h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded">
        <p><strong>Patient:</strong> {{ $appointment->patient->user->name }}</p>
        <p><strong>Doctor:</strong> {{ $appointment->doctor->user->name }}</p>
        <p><strong>Date:</strong> {{ $appointment->appointment_date }}</p>
        <p><strong>Status:</strong> {{ $appointment->status }}</p>
        <p><strong>Notes:</strong> {{ $appointment->notes }}</p>
    </div>
</x-app-layout>
