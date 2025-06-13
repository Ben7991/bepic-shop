<x-layouts.dashboard>
    <x-slot name="title">Products</x-slot>

    <div class="flex gap-2 flex-col md:flex-row md:items-center md:justify-between mb-4 xl:mb-7">
        <h1 class="text-2xl font-bold">Products</h1>
        @if (Auth::user()->role === 'ADMIN')
            <a href="/dashboard/products/create" class="hover:underline text-blue-700">
                Add Poduct <i class="bi bi-arrow-right"></i>
            </a>
        @endif
    </div>

    @if (session('message') && session('variant'))
        <x-molecules.alert message="{{ session()->get('message') }}" variant="{{ session()->get('variant') }}" />
    @endif

    @if (Auth::user()->role === 'ADMIN')
        <div class="bg-white py-2 px-4 rounded-md border border-gray-300 overflow-x-auto">
            <table id="table" class="display w-full">
                <thead>
                    <tr>
                        <th>Date Added</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td class="text-left">{{ $product->created_at }}</td>
                            <td>{{ $product->name }}</td>
                            <td>&#8373; {{ number_format($product->price, 2) }}</td>
                            <td>
                                <a class="text-blue-700 hover:underline"
                                    href="/dashboard/products/{{ $product->id }}/edit">
                                    View Details <i class="bi bi-arrow-right"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        {{-- for distributors --}}
    @endif

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
