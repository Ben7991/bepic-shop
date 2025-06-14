<x-layouts.dashboard>
    <x-slot name="title">Distributors</x-slot>

    <h1 class="text-2xl font-bold mb-4">Distributors</h1>

    <div class="flex gap-2 flex-col md:flex-row md:items-center md:justify-between mb-4 xl:mb-7">
        <a href="/dashboard/distributors" class="flex items-center gap-3 hover:underline text-blue-700 mb-4">
            <i class="bi bi-arrow-left"></i>
            <span>Go back</span>
        </a>
    </div>

    @if (session('message') && session('variant'))
        <x-molecules.alert message="{{ session()->get('message') }}" variant="{{ session()->get('variant') }}" />
    @endif

    <div class="bg-white py-3 px-4 md:py-3 rounded-md border border-gray-300 xl:p-5 mb-5">
        <h4 class="font-bold text-[1.2em] mb-4">Edit distributor</h4>

        <form action="/dashboard/distributors/{{ $user->id }}" method="POST">
            @csrf
            @method('PUT')

            <div class="flex gap-4 flex-wrap">
                <div class="mb-3 md:w-[300px]">
                    <label for="name" class="mb-1 inline-block">Name</label>
                    <input type="text" name="name" id="name" value="{{ $user->name }}"
                        class="px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]" />
                    @error('name')
                        <small class="text-red-700">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3 md:w-[300px]">
                    <label for="username" class="mb-1 inline-block">Username</label>
                    <input type="text" id="username" value="{{ $user->username }}" readonly
                        class="px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]" />
                </div>
                <div class="mb-3 md:w-[300px]">
                    <label for="upline_id" class="mb-1 inline-block">Upline</label>
                    <input type="text" id="upline_id" value="{{ $user->distributor->upline->user->name }}" readonly
                        class="px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]" />
                </div>
                <div class="mb-3 md:w-[300px]">
                    <label for="leg" class="mb-1 inline-block">Select leg</label>
                    <input type="text" id="leg" value="{{ $user->distributor->leg }}" readonly
                        class="px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]" />
                </div>
                <div class="mb-3 md:w-[300px]">
                    <label for="phone" class="mb-1  inline-block">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ $user->distributor->phone_number }}"
                        class="px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]" />
                    @error('phone')
                        <small class="text-red-700">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-4 md:w-[300px]">
                    <label for="country" class="mb-1 inline-block">Country</label>
                    <input type="text" name="country" id="country" value="{{ $user->distributor->country }}"
                        class="px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]" />
                    @error('country')
                        <small class="text-red-700">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3 md:w-[300px]">
                    <label for="wallet" class="mb-1 inline-block">Wallet</label>
                    <input type="text" id="wallet" value="{{ $user->distributor->wallet }}" readonly
                        class="px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]" />
                </div>
            </div>

            <button
                class="cursor-pointer py-2 bg-[var(--sea-blue-100)] text-white hover:bg-[var(--sea-blue-900)] active:bg-[var(--sea-blue-500)] rounded-lg w-[150px]">
                <i class="bi bi-save"></i> Save changes
            </button>
        </form>
    </div>

    <div
        class="bg-white py-3 px-4 md:py-3 rounded-md border border-gray-300 w-full md:w-[450px] md:p-4 xl:w-[500px] xl:p-5">
        <h4 class="font-bold text-[1.2em] mb-4">Transer wallet</h4>

        <form action="/dashboard/distributors/{{ $user->id }}/transfer-wallet" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="amount" class="mb-1 inline-block">Amount</label>
                <input type="text" name="amount" id="amount" value="{{ old('amount') }}"
                    class="px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]" />
                @error('amount')
                    <small class="text-red-700">{{ $message }}</small>
                @enderror
            </div>

            <button
                class="cursor-pointer py-2 bg-[var(--sea-blue-100)] text-white hover:bg-[var(--sea-blue-900)] active:bg-[var(--sea-blue-500)] rounded-lg w-[110px]">
                <i class="bi bi-check2"></i> Submit
            </button>
        </form>
    </div>
</x-layouts.dashboard>
