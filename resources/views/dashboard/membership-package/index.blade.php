<x-layouts.dashboard>
    <x-slot name="title">Membership Packages</x-slot>

    <div class="flex gap-2 flex-col md:flex-row md:items-center md:justify-between mb-4 xl:mb-7">
        <h1 class="text-2xl font-bold">Membership Packages</h1>
        @if (Auth::user()->role === 'ADMIN')
            <a href="/dashboard/membership-packages/create" class="hover:underline text-blue-700">
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
                    <th>Product Quantity</th>
                    <th>Price</th>
                    @if (Auth::user()->role === 'ADMIN')
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($packages as $package)
                    <tr>
                        <td class="text-left">{{ $package->created_at }}</td>
                        <td>{{ number_format($package->point) }}</td>
                        <td>{{ number_format($package->product_quantity) }}</td>
                        <td>&#8373;{{ number_format($package->price, 2) }}</td>
                        @if (Auth::user()->role === 'ADMIN')
                            <td>
                                <a class="text-blue-700 hover:underline"
                                    href="/dashboard/membership-packages/{{ $package->id }}/edit">
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
