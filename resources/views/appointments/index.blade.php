<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold">Appointments</h2>
    </x-slot>

    <form method="GET" class="mb-4 bg-white shadow p-4 rounded">
    <div class="grid grid-cols-4 gap-4">

        <div>
            <label class="block text-sm">Doctor</label>
            <select name="doctor_id" class="w-full border rounded">
                <option value="">All Doctors</option>
                @foreach ($doctors as $d)
                    <option value="{{ $d->id }}" 
                            {{ request('doctor_id') == $d->id ? 'selected' : '' }}>
                        {{ $d->user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm">Patient</label>
            <select name="patient_id" class="w-full border rounded">
                <option value="">All Patients</option>
                @foreach ($patients as $p)
                    <option value="{{ $p->id }}"
                            {{ request('patient_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm">From</label>
            <input type="date" name="date_from" class="w-full border rounded"
                   value="{{ request('date_from') }}">
        </div>

        <div>
            <label class="block text-sm">To</label>
            <input type="date" name="date_to" class="w-full border rounded"
                   value="{{ request('date_to') }}">
        </div>

        <div>
            <label class="block text-sm">Status</label>
            <select name="status" class="w-full border rounded">
                <option value="">Any</option>
                @foreach (['pending','approved','canceled','completed'] as $s)
                    <option value="{{ $s }}"
                        {{ request('status') == $s ? 'selected' : '' }}>
                        {{ ucfirst($s) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-span-2">
            <label class="block text-sm">Keyword</label>
            <input type="text" name="keyword" placeholder="Search names or notes"
                   class="w-full border rounded"
                   value="{{ request('keyword') }}">
        </div>

        <div class="flex items-end">
            <button class="px-4 py-2 bg-blue-600 text-white rounded w-full">
                Filter
            </button>
        </div>

    </div>
</form>


    <div class="py-6">
        <a href="{{ route('appointments.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded">New Appointment</a>

        <div class="mt-4 bg-white shadow rounded">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="p-3 text-left">Patient</th>
                        <th class="p-3 text-left">Doctor</th>
                        <th class="p-3 text-left">Date</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $a)
                        <tr class="border-b">
                            <td class="p-3">{{ $a->patient->user->name }}</td>
                            <td class="p-3">{{ $a->doctor->user->name }}</td>
                            <td class="p-3">{{ $a->appointment_date }}</td>
                            <td class="p-3">{{ $a->status }}</td>
                            <td class="p-3">
                                <a href="{{ route('appointments.show', $a) }}"
                                   class="text-blue-600">Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-4">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
