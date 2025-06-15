<x-layouts.dashboard>
    <x-slot name="title">Dashboard</x-slot>

    <h1 class="text-2xl font-bold mb-4 xl:mb-7">Dashboard</h1>

    @if (Auth::user()->role === 'DISTRIBUTOR') {{-- below is for distributor dashboard --}}
        <div class="flex flex-wrap gap-3 md:gap-4 mb-4 xl:mb-7">
            <div
                class="bg-green-100 rounded-md flex justify-between basis-full px-4 md:basis-1/4 py-3 xl:p-5 xl:basis-1/5 2xl:basis-1/6">
                <div class="text-left">
                    <p class="mb-1">ID</p>
                    <h4 class="font-semibold text-xl">{{ Auth::user()->id }}</h4>
                </div>
                <i class="bi bi-person-badge text-3xl"></i>
            </div>
            <div
                class="bg-blue-100 rounded-md flex justify-between basis-full px-4 py-3 md:basis-1/4 xl:p-5 xl:basis-1/5 2xl:basis-1/6">
                <div class="text-left">
                    <p class="mb-1">Wallet</p>
                    <h4 class="font-semibold text-xl">&#8373; {{ number_format(Auth::user()->distributor->wallet, 2) }}
                    </h4>
                </div>
                <i class="bi bi-wallet text-3xl"></i>
            </div>
            <div
                class="bg-red-100 rounded-md flex justify-between basis-full px-4 py-3 md:basis-1/4 xl:p-5 xl:basis-1/5 2xl:basis-1/6">
                <div class="text-left">
                    <p class="mb-1">Bonus</p>
                    <h4 class="font-semibold text-xl">&#8373; {{ number_format(Auth::user()->distributor->bonus, 2) }}
                    </h4>
                </div>
                <i class="bi bi-cash-stack text-3xl"></i>
            </div>
            <div
                class="bg-yellow-100 rounded-md flex justify-between basis-full px-4 py-3 md:basis-1/4 xl:p-5 xl:basis-1/5 2xl:basis-1/6">
                <div class="text-left">
                    <p class="mb-1">Distributors Added</p>
                    <h4 class="font-semibold text-xl">{{ $users_added }}</h4>
                </div>
                <i class="bi bi-person-plus text-3xl"></i>
            </div>
            <div
                class="bg-purple-100 rounded-md flex justify-between basis-full px-4 py-3 md:basis-1/4 xl:p-5 xl:basis-1/5 2xl:basis-1/6">
                <div class="text-left">
                    <p class="mb-1">Remaining Days</p>
                    <h4 class="font-semibold text-xl">{{ $remainingDays }}</h4>
                </div>
                <i class="bi bi-calendar4-week text-3xl"></i>
            </div>
            <div
                class="bg-orange-100 rounded-md flex justify-between basis-full px-4 py-3 md:basis-1/4 xl:p-5 xl:basis-1/5 2xl:basis-1/6">
                <div class="text-left">
                    <p class="mb-1">Total Orders</p>
                    <h4 class="font-semibold text-xl">&#8373; {{ number_format($totalOrders, 2) }}</h4>
                </div>
                <i class="bi bi-graph-up-arrow text-3xl"></i>
            </div>
        </div>

        <div class="bg-white py-2 px-4 md:py-3 rounded-md border border-gray-300 overflow-x-auto md:mb-4 xl:p-5">
            <h4 class="mb-4 font-semibold text-[1.2em]">Recent Transactions</h4>
            <table id="table-transaction" class="display w-full">
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
                            <td>&#8373; {{ $transaction->amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white py-2 px-4 md:py-3 rounded-md border border-gray-300 overflow-x-auto xl:p-5">
            <h4 class="mb-4 font-semibold text-[1.2em]">Recent Withdrawals</h4>
            <table id="table-withdrawal" class="display w-full">
                <thead>
                    <tr>
                        <th>Date Added</th>
                        <th>Amount</th>
                        <th>Deduction (10%)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($withdrawals as $withdrawal)
                        <tr>
                            <td class="text-left">{{ $withdrawal->created_at }}</td>
                            <td class="text-left">&#8373; {{ $withdrawal->amount }}</td>
                            <td class="text-left">&#8373; {{ $withdrawal->deduction }}</td>
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
                    $('#table-transaction').DataTable({
                        ordering: false
                    });

                    $('#table-withdrawal').DataTable({
                        ordering: false
                    });
                });
            </script>
        @endpush
    @else
        {{-- below is for admin dashboard --}}
        <div class="flex flex-wrap gap-3 md:gap-4 mb-4 xl:mb-7">
            <div class="bg-green-100 rounded-md flex justify-between basis-[48%] px-4 py-3 md:basis-1/4 xl:p-5">
                <div class="text-left">
                    <p class="mb-1">Total Distributors</p>
                    <h4 class="font-semibold text-xl">{{ $distributorCount }}</h4>
                </div>
                <i class="bi bi-people text-3xl"></i>
            </div>
            <div class="bg-blue-100 rounded-md flex justify-between basis-[48%] px-4 py-3 md:basis-1/4 xl:p-5">
                <div class="text-left">
                    <p class="mb-1">Wallet Transfer</p>
                    <h4 class="font-semibold text-xl">{{ $walletTransferCount }}</h4>
                </div>
                <i class="bi bi-wallet text-3xl"></i>
            </div>
            <div class="bg-red-100 rounded-md flex justify-between basis-[48%] px-4 py-3 md:basis-1/4 xl:p-5">
                <div class="text-left">
                    <p class="mb-1">Bonus Withdrawals</p>
                    <h4 class="font-semibold text-xl">{{ $bonusWithdrawalCount }}</h4>
                </div>
                <i class="bi bi-cash-stack text-3xl"></i>
            </div>
        </div>

        <div class="bg-white py-2 px-4 rounded-md border border-gray-300 overflow-x-auto mb-5 xl:p-5">
            <h4 class="mb-4 font-semibold text-[1.2em]">Recent Distributors</h4>
            <table id="table" class="display w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date Joined</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Wallet</th>
                        <th>Country</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentDistributors as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td class="text-left">{{ $user->distributor->created_at }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>&#8373; {{ $user->distributor->wallet }}</td>
                            <td>{{ $user->distributor->country }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white py-2 px-4 md:py-3 rounded-md border border-gray-300 overflow-x-auto xl:p-5 mt-7">
            <h4 class="mb-4 font-semibold text-[1.2em]">Recent Withdrawals</h4>
            <table id="table-withdrawal" class="display w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date Added</th>
                        <th>Distributor Details</th>
                        <th>Amount</th>
                        <th>Deduction (10%)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentWithdrawals as $withdrawal)
                        <tr>
                            <td>{{ $withdrawal->id }}</td>
                            <td class="text-left">{{ $withdrawal->created_at }}</td>
                            <td>
                                {{ $withdrawal->distributor->user->name }} - {{ $withdrawal->distributor->user->id }}
                                - {{ $withdrawal->distributor->user->username }}
                            </td>
                            <td class="text-left">&#8373; {{ $withdrawal->amount }}</td>
                            <td class="text-left">&#8373; {{ $withdrawal->deduction }}</td>
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
                    $('#table').DataTable({
                        ordering: false
                    });

                    $('#table-withdrawal').DataTable({
                        ordering: false
                    });
                });
            </script>
        @endpush
    @endif

</x-layouts.dashboard>
