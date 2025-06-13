@props(['variant', 'message'])

<div class="fixed top-5 md:top-12 left-1/2 -translate-x-1/2 shadow-md rounded-lg z-50 w-[90%] md:w-[554px] flex
    items-center justify-between py-3 px-4 bg-white {{ $variant === 'success' ? 'border border-[var(--success-700)] text-[var(--success-100)]' : 'border border-[var(--error-500)] text-[var(--error-100)]' }}"
    role="alert" id="alert">
    <div class="flex gap-3 items-center">
        @if ($variant === 'success')
            <i class="bi bi-check2 text-xl text-[var(--success-100)]"></i>
        @elseif ($variant === 'error')
            <i class="bi bi-x-circle text-xl text-[var(--error-100)]"></i>
        @endif
        <p>{{ $message }}</p>
    </div>
    <button class="inline-block text-gray-500 hover:text-[var(--error-100)] cursor-pointer" id="alert-btn-close">
        <i class="bi bi-x-lg text-xl"></i>
    </button>
</div>

<script>
    window.onload = function() {
        const alert = document.getElementById('alert');
        const alertBtnClose = document.getElementById('alert-btn-close');

        if (alert && alertBtnClose) {
            alertBtnClose.addEventListener('click', () => {
                alert.remove();
            });

            setTimeout(() => {
                alert.remove();
            }, 3000);
        }
    }
</script>
