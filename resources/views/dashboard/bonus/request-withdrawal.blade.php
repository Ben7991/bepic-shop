<x-layouts.dashboard>
    <x-slot name="title">Request Withdrawal</x-slot>

    <h1 class="text-2xl font-bold mb-4 xl:mb-7">Request Withdrawal</h1>

    @if (session('message') && session('variant'))
        <x-molecules.alert message="{{ session()->get('message') }}" variant="{{ session()->get('variant') }}" />
    @endif

    <form action="/dashboard/request-withdrawal" method="POST">
        @csrf

        <div class="md:flex gap-3">
            <input type="number" name="amount"
                class="px-4 border rounded-lg gap-2 form-control w-[300px] py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]"
                placeholder="Enter amount to withdraw" />
            <button
                class="cursor-pointer py-2 bg-[var(--sea-blue-100)] text-white hover:bg-[var(--sea-blue-900)] active:bg-[var(--sea-blue-500)] rounded-lg w-[150px]">
                <i class="bi bi-send"></i> Send Request
            </button>
        </div>
    </form>

    <div class="bg-white py-2 px-4 md:py-3 rounded-md border border-gray-300 overflow-x-auto xl:p-5 mt-7">
        <table id="table-withdrawal" class="display w-full">
            <thead>
                <tr>
                    <th>Date Added</th>
                    <th>Amount</th>
                    <th>Deduction (10%)</th>
                    <th>Amount to Pay</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($withdrawals as $withdrawal)
                    <tr>
                        <td class="text-left">{{ $withdrawal->created_at }}</td>
                        <td class="text-left">&#8373; {{ number_format($withdrawal->amount, 2) }}</td>
                        <td class="text-left">&#8373; {{ number_format($withdrawal->deduction, 2) }}</td>
                        <td class="text-left">&#8373;
                            {{ number_format($withdrawal->amount - $withdrawal->deduction, 2) }}</td>
                        <td>
                            <small
                                class="inline-block py-1 px-2 rounded-md {{ $withdrawal->status === 'APPROVED' ? 'text-green-700 bg-green-100' : 'text-white bg-gray-400' }}">
                                {{ $withdrawal->status }}
                            </small>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#table-withdrawal').DataTable({
                    ordering: false
                });
            });
        </script>
    @endpush
</x-layouts.dashboard>
