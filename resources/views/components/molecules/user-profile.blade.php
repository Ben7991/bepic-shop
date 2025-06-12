@props(['initials', 'name', 'role'])

<div class="flex items-center gap-4 basis-[234px]">
    <div class="w-12 h-12 rounded-full border border-[var(--gray-700)] flex items-center justify-center">
        {{ $initials }}
    </div>
    <div>
        <h4 class="text-[1em] font-medium">{{ $name }}</h4>
        <p class="text-[0.875em]">{{ $role }}</p>
    </div>
</div>
