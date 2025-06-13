<x-layouts.dashboard>
    <x-slot name="title">Incentives</x-slot>

    <div class="flex gap-2 flex-col md:flex-row md:items-center md:justify-between mb-4 xl:mb-7">
        <h1 class="text-2xl font-bold">Incentives</h1>
        @if (Auth::user()->role === 'ADMIN')
            <a href="/dashboard/incentives/create" class="hover:underline text-blue-700">
                Add Package <i class="bi bi-arrow-right"></i>
            </a>
        @endif
    </div>

    @if (session('message') && session('variant'))
        <x-molecules.alert message="{{ session()->get('message') }}" variant="{{ session()->get('variant') }}" />
    @endif

    <div class="bg-white py-2 px-4 rounded-md border border-gray-300 overflow-x-auto">
        <table id="table" class="display w-full">
            <thead>
                <tr>
                    <th>Date Added</th>
                    <th>Point</th>
                    <th>Award</th>
                    @if (Auth::user()->role === 'ADMIN')
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($incentives as $incentive)
                    <tr>
                        <td class="text-left">{{ $incentive->created_at }}</td>
                        <td>{{ number_format($incentive->point) }}</td>
                        <td>{{ $incentive->award }}</td>
                        @if (Auth::user()->role === 'ADMIN')
                            <td>
                                <a class="text-blue-700 hover:underline"
                                    href="/dashboard/incentives/{{ $incentive->id }}/edit">
                                    View Details <i class="bi bi-arrow-right"></i>
                                </a>
                            </td>
                        @endif
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
