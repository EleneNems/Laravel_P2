<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Create Visit</h2>
    </x-slot>

    <form class="max-w-lg mx-auto mt-6" method="POST" action="{{ route('visits.store') }}">
        @csrf

        <div class="mb-4">
            <label>Appointment</label>
            <select name="appointment_id" class="w-full border p-2">
                @foreach ($appointments as $a)
                    <option value="{{ $a->id }}">
                        {{ $a->patient->user->name }} → {{ $a->doctor->user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label>Diagnosis</label>
            <textarea name="diagnosis" class="w-full border p-2"></textarea>
        </div>

        <div class="mb-4">
            <label>Treatment</label>
            <textarea name="treatment" class="w-full border p-2"></textarea>
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
    </form>
</x-app-layout>
