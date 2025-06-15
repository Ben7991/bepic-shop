<x-layouts.dashboard>
    <x-slot name="title">Transactions</x-slot>

    <h1 class="text-2xl font-bold mb-4 md:mb-7">Transactions</h1>

    <div class="bg-white py-2 px-4 rounded-md border border-gray-300 overflow-x-auto">
        <table id="table" class="display w-full">
            <thead>
                <tr>
                    <th>Date Added</th>
                    <th>Transaction Type</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td class="text-left">{{ $transaction->created_at }}</td>
                        <td>
                            @if ($transaction->transaction_type === 'DEPOSIT')
                                <small class="inline-block py-1 px-2 rounded-md text-gray-700 bg-gray-100">
                                    {{ $transaction->transaction_type }}
                                </small>
                            @elseif ($transaction->transaction_type === 'BONUS')
                                <small class="inline-block py-1 px-2 rounded-md text-green-700 bg-green-100">
                                    {{ $transaction->transaction_type }}
                                </small>
                            @else
                                <small class="inline-block py-1 px-2 rounded-md text-orange-700 bg-orange-100">
                                    {{ $transaction->transaction_type }}
                                </small>
                            @endif
                        </td>
                        <td>&#8373; {{ number_format($transaction->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#table').DataTable({
                    ordering: false
                });
            });
        </script>
    @endpush
</x-layouts.dashboard>
