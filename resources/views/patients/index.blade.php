<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Patients</h2>
    </x-slot>

    <form method="GET" class="mb-4">
    <input type="text" name="keyword" placeholder="Search patients..."
           value="{{ request('keyword') }}"
           class="border rounded p-2 w-64">
    <button class="px-4 py-2 bg-blue-600 text-white rounded">Search</button>
</form>


    <div class="bg-white shadow rounded p-4">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="p-2 text-left">Name</th>
                    <th class="p-2 text-left">Email</th>
                    <th class="p-2 text-left">Insurance</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($patients as $p)
                    <tr class="border-t">
                        <td class="p-2">{{ $p->user->name }}</td>
                        <td class="p-2">{{ $p->user->email }}</td>
                        <td class="p-2">{{ $p->insurance_number }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $patients->links() }}
        </div>
    </div>
</x-app-layout>
