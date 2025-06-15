<x-layouts.dashboard>
    <x-slot name="title">Account Settings</x-slot>

    <h1 class="text-2xl font-bold mb-4 xl:mb-7">Account Settings</h1>

    @if (session('message') && session('variant'))
        <x-molecules.alert message="{{ session()->get('message') }}" variant="{{ session()->get('variant') }}" />
    @endif

    <div class="flex gap-4 items-center my-5 lg:mb-10">
        <div
            class="w-[114px] h-[114px] rounded-full border border-[var(--gray-700)] flex items-center justify-center text-2xl">
            @php
                $name = Auth::user()->name;
                $initials = Str::substr($name, 0, 1);
                $hasMultipleNames = false;
                $index = 0;

                for ($i = 0; $i < Str::length($name); $i++) {
                    if ($name[$i] === ' ') {
                        $hasMultipleNames = true;
                        $index = $i;
                        break;
                    }
                }

                if ($hasMultipleNames) {
                    $initials .= Str::substr($name, $index + 1, 1);
                }
            @endphp
            {{ $initials }}
        </div>
        <div class="space-y-2">
            <h4 class="font-bold text-[1.2em] mb-1">{{ Auth::user()->name }}</h4>
            <p>{{ Auth::user()->role }}</p>
        </div>
    </div>
    <section class="flex flex-col md:flex-row gap-4 xl:gap-20 items-start">
        <div
            class="bg-white py-3 px-4 md:py-3 rounded-md border border-gray-300 w-full md:w-[350px] md:p-4 xl:w-[500px] xl:p-5">
            <h4 class="font-bold text-[1.2em] mb-4">Personal Information</h4>
            <form method="POST" action="/dashboard/account-settings/personal">
                @csrf
                <div class="mb-4">
                    <label for="name" class="inline-block mb-1">Name</label>
                    <input type="text" name="name" id="name"
                        class="px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]"">
                    @error('name')
                        <p class="text-[var(--error-100)]">{{ $message }}</p>
                    @enderror
                </div>
                <button
                    class="cursor-pointer py-2 bg-[var(--sea-blue-100)] text-white hover:bg-[var(--sea-blue-900)] active:bg-[var(--sea-blue-500)] rounded-lg w-[150px]">
                    <i class="bi bi-save"></i> Save changes
                </button>
            </form>
        </div>

        <div
            class="bg-white py-3 px-4 md:py-3 rounded-md border border-gray-300 w-full md:w-[350px] md:p-4 xl:w-[500px] xl:p-5">
            <h4 class="font-bold text-[1.2em] mb-4">Change Password</h4>
            <form method="POST" action="/dashboard/account-settings/pass-code">
                @csrf

                <div class="mb-4">
                    <label for="current_password" class="inline-block mb-1">Current Password</label>
                    <input type="password" name="current_password" id="current_password"
                        class="px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]"">
                    @error('current_password')
                        <p class="text-[var(--error-100)]">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="new_password" class="inline-block mb-1">New Password</label>
                    <input type="password" name="new_password" id="new_password"
                        class="px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]"">
                    @error('new_password')
                        <p class="text-[var(--error-100)]">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="confirm_password" class="inline-block mb-1">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password"
                        class="px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)] focus:border-[var(--sea-blue-100)]"">
                    @error('confirm_password')
                        <p class="text-[var(--error-100)]">{{ $message }}</p>
                    @enderror
                </div>
                <button
                    class="cursor-pointer py-2 bg-[var(--sea-blue-100)] text-white hover:bg-[var(--sea-blue-900)] active:bg-[var(--sea-blue-500)] rounded-lg w-[150px]">
                    <i class="bi bi-save"></i> Save changes
                </button>
            </form>
        </div>
    </section>

</x-layouts.dashboard>
