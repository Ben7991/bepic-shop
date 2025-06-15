<x-layouts.dashboard>
    <x-slot name="title">Awards</x-slot>

    <h1 class="text-2xl font-bold mb-4 md:mb-7">Awards</h1>

    @if (session('message') && session('variant'))
        <x-molecules.alert message="{{ session()->get('message') }}" variant="{{ session()->get('variant') }}" />
    @endif

    <div class="bg-white py-2 px-4 rounded-md border border-gray-300 overflow-x-auto">
        <table id="table" class="display w-full">
            <thead>
                <tr>
                    <th>Date Added</th>
                    <th>Distributor Details</th>
                    <th>Award</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($awards as $award)
                    <tr>
                        <td>{{ $award->created_at }}</td>
                        <td>{{ $award->distributor->user->name }} ({{ $award->distributor->user->username }})</td>
                        <td>{{ $award->incentive->award }}</td>
                        <td>
                            <small
                                class="inline-block py-1 px-2 rounded-md {{ $award->status === 'APPROVED' ? 'text-green-700 bg-green-100' : 'text-white bg-gray-400' }}">
                                {{ $award->status }}
                            </small>
                        </td>
                        <td>
                            @if ($award->status === 'PENDING')
                                <form action="/dashboard/awards/{{ $award->id }}/approve" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <button
                                        class="py-1 px-3 inline-block bg-green-700 text-white rounded cursor-pointer">
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
                $('#table').DataTable({
                    ordering: false
                });
            });
        </script>
    @endpush
</x-layouts.dashboard>
