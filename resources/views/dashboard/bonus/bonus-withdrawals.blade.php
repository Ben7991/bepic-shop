<x-layouts.dashboard>
    <x-slot name="title">Bonus Withdrawals</x-slot>

    <h1 class="text-2xl font-bold mb-4 xl:mb-7">Bonus Withdrawals</h1>

    @if (session('message') && session('variant'))
        <x-molecules.alert message="{{ session()->get('message') }}" variant="{{ session()->get('variant') }}" />
    @endif

    <div class="bg-white py-2 px-4 md:py-3 rounded-md border border-gray-300 overflow-x-auto xl:p-5 mt-7">
        <table id="table-withdrawal" class="display w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date Added</th>
                    <th>Distributor Details</th>
                    <th>Amount</th>
                    <th>Deduction (10%)</th>
                    <th>Amount To Pay</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($withdrawals as $withdrawal)
                    <tr>
                        <td>{{ $withdrawal->id }}</td>
                        <td class="text-left">{{ $withdrawal->created_at }}</td>
                        <td>
                            {{ $withdrawal->distributor->user->name }} - {{ $withdrawal->distributor->user->id }} -
                            {{ $withdrawal->distributor->user->username }}
                        </td>
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
                        <td>
                            @if ($withdrawal->status === 'PENDING')
                                <form action="/dashboard/bonus-withdrawals/{{ $withdrawal->id }}/approve"
                                    method="POST">
                                    @csrf
                                    @method('PUT')

                                    <button class="py-1 px-3 inline-block bg-green-700 text-white rounded">
                                        <i class="bi bi-check2"></i> Approve
                                    </button>
                                </form>
                            @endif
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
