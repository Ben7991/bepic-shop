<x-layouts.dashboard>
    <x-slot name="title">Purchase History</x-slot>

    <h1 class="text-2xl font-bold mb-4 xl:mb-7">Purchase History</h1>

    @if (session('message') && session('variant'))
        <x-molecules.alert message="{{ session()->get('message') }}" variant="{{ session()->get('variant') }}" />
    @endif

    <div class="flex flex-wrap flex-col md:flex-row gap-3 md:gap-4 mb-4 xl:mb-7">
        <div class="bg-red-100 rounded-md flex justify-between basis-[48%] px-4 py-3 md:basis-2/5 xl:basis-1/5 xl:p-5">
            <div class="text-left">
                <p class="mb-1">Pending Orders</p>
                <h4 class="font-semibold text-xl">{{ $pending }}</h4>
            </div>
            <i class="bi bi-clock text-3xl text-[var(--error-100)]"></i>
        </div>
        <div
            class="bg-green-100 rounded-md flex justify-between basis-[48%] px-4 py-3 md:basis-2/5 xl:basis-1/5 xl:p-5">
            <div class="text-left">
                <p class="mb-1">Total Orders</p>
                <h4 class="font-semibold text-xl">{{ count($orders) }}</h4>
            </div>
            <i class="bi bi-check2 text-3xl text-[var(--success-100)]"></i>
        </div>
    </div>

    <div class="bg-white py-2 px-4 rounded-md border border-gray-300 overflow-x-auto">
        <table id="table" class="display w-full">
            <thead>
                <tr>
                    <th>Date Added</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Order Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td class="text-left">{{ $order->created_at }}</td>
                        <td>{{ $order->product->name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>&#8373; {{ number_format($order->product->price * $order->quantity, 2) }}</td>
                        <td>
                            <small
                                class="inline-block py-1 px-2 rounded-md {{ $order->purchase_type === 'REORDER' ? 'text-blue-700 bg-green-100' : 'text-white bg-orange-400' }}">
                                {{ $order->purchase_type }}
                            </small>
                        </td>
                        <td>
                            <small
                                class="inline-block py-1 px-2 rounded-md {{ $order->status === 'APPROVED' ? 'text-green-700 bg-green-100' : 'text-white bg-gray-400' }}">
                                {{ $order->status }}
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
