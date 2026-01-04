<x-layouts.dashboard>
    <x-slot name="title">Incentives Won</x-slot>

    <h1 class="text-2xl font-bold mb-4 md:mb-7">Incentives Won</h1>

    <div class="bg-white py-2 px-4 rounded-md border border-gray-300 overflow-x-auto">
        <table id="table" class="display w-full">
            <thead>
                <tr>
                    <th>Date Added</th>
                    <th>Award</th>
                    <th>From</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($awards as $award)
                    <tr>
                        <td>{{ $award->created_at }}</td>
                        <td>{{ $award->award }}</td>
                        <td>{{ $award->from }}</td>
                        <td>
                            <small
                                class="inline-block py-1 px-2 rounded-md {{ $award->status === 'APPROVED' ? 'text-green-700 bg-green-100' : 'text-white bg-gray-400' }}">
                                {{ $award->status }}
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
            });
        </script>
    @endpush
</x-layouts.dashboard>
