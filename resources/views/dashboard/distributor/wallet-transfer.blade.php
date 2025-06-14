<x-layouts.dashboard>
    <x-slot name="title">Distributors</x-slot>

    <h1 class="text-2xl font-bold mb-4">Distributors</h1>

    <div class="flex gap-2 flex-col md:flex-row md:items-center md:justify-between mb-4 xl:mb-7">
        <a href="/dashboard/distributors" class="flex items-center gap-3 hover:underline text-blue-700 mb-4">
            <i class="bi bi-arrow-left"></i>
            <span>Go back</span>
        </a>
    </div>

    <div class="bg-white py-2 px-4 rounded-md border border-gray-300 overflow-x-auto">
        <table id="table" class="display w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date of Transfer</th>
                    <th>Distributor ID</th>
                    <th>Distributor Name</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->created_at }}</td>
                        <td>{{ $transaction->distributor->user->id }}</td>
                        <td>{{ $transaction->distributor->user->name }}</td>
                        <td>&#8373;{{ number_format($transaction->amount, 2) }}</td>
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
