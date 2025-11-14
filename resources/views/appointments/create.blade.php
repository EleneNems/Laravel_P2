<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Create Appointment</h2>
    </x-slot>

    <form class="max-w-lg mx-auto mt-6" method="POST" action="{{ route('appointments.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Patient</label>
            <select name="patient_id" class="w-full border rounded p-2">
                @foreach ($patients as $p)
                    <option value="{{ $p->id }}">{{ $p->user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Doctor</label>
            <select name="doctor_id" class="w-full border rounded p-2">
                @foreach ($doctors as $d)
                    <option value="{{ $d->id }}">{{ $d->user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Date</label>
            <input type="datetime-local" name="appointment_date" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>Notes</label>
            <textarea name="notes" class="w-full border rounded p-2"></textarea>
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded">Create</button>
    </form>
</x-app-layout>
