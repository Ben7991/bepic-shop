<x-layouts.dashboard>
    <x-slot name="title">Products</x-slot>

    <h1 class="text-2xl font-bold mb-4">Products</h1>

    <div class="flex gap-2 flex-col md:flex-row md:items-center md:justify-between mb-4 xl:mb-7">
        <a href="/dashboard/products" class="flex items-center gap-3 hover:underline text-blue-700 mb-4">
            <i class="bi bi-arrow-left"></i>
            <span>Go back</span>
        </a>
    </div>

    @if (session('message') && session('variant'))
        <x-molecules.alert message="{{ session()->get('message') }}" variant="{{ session()->get('variant') }}" />
    @endif

    <div
        class="bg-white py-3 px-4 md:py-3 rounded-md border border-gray-300 w-full md:w-[500px] md:p-4 xl:w-[550px] xl:p-5">
        <h4 class="font-bold text-[1.2em] mb-4">Edit product</h4>
        <form action="/dashboard/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="mb-1 inline-block">Name</label>
                <input type="text" name="name" id="name" value={{ $product->name }}
                    class="px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]" />
                @error('name')
                    <small class="text-red-700">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="price" class="mb-1 inline-block">Price</label>
                <input type="number" name="price" id="price" value={{ $product->price }}
                    class="px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]">
                @error('price')
                    <small class="text-red-700">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="details" class="mb-1 inline-block">Description</label>
                <textarea name="details" rows="7"
                    class="px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]">{{ $product->details }}</textarea>
                @error('details')
                    <small class="text-red-700">{{ $message }}</small>
                @enderror
            </div>

            <button
                class="cursor-pointer py-2 bg-[var(--sea-blue-100)] text-white hover:bg-[var(--sea-blue-900)] active:bg-[var(--sea-blue-500)] rounded-lg w-[150px]">
                <i class="bi bi-save"></i> Save changes
            </button>
        </form>
    </div>


</x-layouts.dashboard>
