<x-layouts.dashboard>
    <x-slot name="title">Distributors</x-slot>

    <div class="flex gap-2 flex-col md:flex-row md:items-center md:justify-between mb-4 xl:mb-7">
        <h1 class="text-2xl font-bold">Distributors</h1>
        <div class="flex items-center gap-3">
            <a href="/dashboard/distributors/create" class="underline text-blue-700">
                Add Distributor
            </a>
            <a href="/dashboard/distributors/wallet-transfers" class="underline text-blue-700">
                View Wallet Transfers
            </a>
        </div>
    </div>

    @if (session('message'))
        <div class="bg-green-100 text-green-700 p-3 rounded-md mb-4">
            {{ session()->get('message') }}
        </div>
    @endif

    <div class="bg-white py-2 px-4 rounded-md border border-gray-300 overflow-x-auto">
        <table id="table" class="display w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Upline</th>
                    <th>Country</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ Str::length($user->distributor->upline->user->name) > 10 ? Str::substr($user->distributor->upline->user->name, 0, 10) . '...' : $user->distributor->upline->user->name }}({{ $user->distributor->upline->user->id }})
                        </td>
                        <td>{{ $user->distributor->country }}</td>
                        <td>
                            <a class="text-blue-700 hover:underline"
                                href="/dashboard/distributors/{{ $user->id }}/edit">
                                View Details <i class="bi bi-arrow-right"></i>
                            </a>
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
            });
        </script>
    @endpush

</x-layouts.dashboard>
