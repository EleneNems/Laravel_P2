<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Doctors</h2>
    </x-slot>

    <form method="GET" class="mb-4">
    <input type="text" name="keyword" placeholder="Doctor name..."
           value="{{ request('keyword') }}"
           class="border rounded p-2">

    <input type="text" name="specialization" placeholder="Specialization"
           value="{{ request('specialization') }}"
           class="border rounded p-2">

    <button class="px-4 py-2 bg-blue-600 text-white rounded">Search</button>
</form>


    <div class="py-6 bg-white shadow rounded p-4">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="p-2 text-left">Name</th>
                    <th class="p-2 text-left">Specialization</th>
                    <th class="p-2 text-left">Room</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($doctors as $d)
                    <tr class="border-t">
                        <td class="p-2">{{ $d->user->name }}</td>
                        <td class="p-2">{{ $d->specialization }}</td>
                        <td class="p-2">{{ $d->room_number }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $doctors->links() }}
        </div>
    </div>
</x-app-layout>
