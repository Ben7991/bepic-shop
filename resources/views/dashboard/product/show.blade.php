<x-layouts.dashboard>
    <x-slot name="title">Products</x-slot>

    <h1 class="text-2xl font-bold mb-4">{{ $product->name }}</h1>

    <div class="flex gap-2 flex-col md:flex-row md:items-center md:justify-between mb-4 xl:mb-7">
        <a href="/dashboard/products" class="flex items-center gap-3 hover:underline text-blue-700 mb-4">
            <i class="bi bi-arrow-left"></i>
            <span>Go back</span>
        </a>
    </div>

    @if (session('message') && session('variant'))
        <x-molecules.alert message="{{ session()->get('message') }}" variant="{{ session()->get('variant') }}" />
    @endif

    <div class="flex flex-col md:flex-row md:gap-5">
        <div class="bg-white p-3 rounded-md border border-gray-300 mb-3 md:mb-0 md:basis-[250px] lg:basis-[350px]">
            <img src="{{ asset('storage/' . $product->image) }}" class="w-full" />
        </div>
        <div class="md:basis-[calc(100%-250px)] xl:basis-[450px]">
            <h4 class="font-semibold text-2xl mb-3">Price: &#8373; {{ $product->price }}</h4>
            <p class="mb-3">Points: {{ $product->points }}</p>
            <p class="mb-4">Package details: {{ $product->details }}</p>

            <div class="bg-white border border-gray-300 p-4 rounded-md">
                <h3 class="font-semibold text-xl mb-4">Purchase Product</h3>
                <form method="POST" action="/dashboard/products/{{ $product->id }}/purchase">
                    @csrf
                    <div class="mb-3 md:mb-4">
                        <label for="purchase_type" class="inline-block mb-1">Purchase Type</label>
                        <select name="purchase_type" id="purchase_type"
                            class="px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]">
                            <option value="">Select purchase type</option>
                            <option value="MAINTENANCE">Maintenance</option>
                            <option value="REORDER">Re-Order</option>
                        </select>
                        @error('purchase_type')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3 md:mb-4">
                        <label for="quantity" class="inline-block mb-1">Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}"
                            class="px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]">
                        @error('quantity')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <button
                        class="cursor-pointer py-2 bg-[var(--sea-blue-100)] text-white hover:bg-[var(--sea-blue-900)] active:bg-[var(--sea-blue-500)] rounded-lg w-[170px]">
                        <i class="bi bi-save"></i> Purchase Product
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
