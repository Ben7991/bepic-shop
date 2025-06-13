<div class="flex items-center gap-4 basis-[234px]">
    <div class="w-12 h-12 rounded-full border border-[var(--gray-700)] flex items-center justify-center">
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
    <div>
        <h4 class="text-[1em] font-medium">{{ Auth::user()->name }}</h4>
        <p class="text-[0.875em]">{{ Auth::user()->role }}</p>
    </div>
</div>
