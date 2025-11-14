<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Payments</h2>
    </x-slot>

    <div class="bg-white shadow rounded p-4">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="p-2 text-left">Patient</th>
                    <th class="p-2 text-left">Amount</th>
                    <th class="p-2 text-left">Method</th>
                    <th class="p-2 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $pay)
                    <tr class="border-t">
                        <td class="p-2">{{ $pay->visit->appointment->patient->user->name }}</td>
                        <td class="p-2">${{ $pay->amount }}</td>
                        <td class="p-2">{{ $pay->payment_method }}</td>
                        <td class="p-2">{{ $pay->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $payments->links() }}
        </div>
    </div>
</x-app-layout>
