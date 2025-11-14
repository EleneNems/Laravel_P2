<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="py-6">
        <div class="grid grid-cols-4 gap-4">

            {{-- Example statistics --}}
            <div class="p-6 bg-white shadow rounded">
                <h3 class="text-lg font-medium">Patients</h3>
                <p class="text-2xl font-bold">{{ $patientsCount }}</p>
            </div>

            <div class="p-6 bg-white shadow rounded">
                <h3 class="text-lg font-medium">Doctors</h3>
                <p class="text-2xl font-bold">{{ $doctorsCount }}</p>
            </div>

            <div class="p-6 bg-white shadow rounded">
                <h3 class="text-lg font-medium">Appointments</h3>
                <p class="text-2xl font-bold">{{ $appointmentsCount }}</p>
            </div>

            <div class="p-6 bg-white shadow rounded">
                <h3 class="text-lg font-medium">Visits</h3>
                <p class="text-2xl font-bold">{{ $visitsCount }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
