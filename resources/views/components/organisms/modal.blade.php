@props(['title'])

<x-atoms.backdrop id="modal-backdrop" />
<dialog class="bg-white fixed top-1/2 left-1/2 -translate-1/2 w-[90%] md:w-[460px] rounded-lg p-4 lg:px-8 lg:py-6 z-20"
    id="modal">
    <header class="flex items-center justify-between mb-4">
        <h3 class="text-2xl">{{ $title }}</h3>
        <button class="inline-block hover:text-[var(--error-100)] cursor-pointer" id="modal-close-btn">
            <i class="bi bi-x-lg text-xl"></i>
        </button>
    </header>
    <section>{{ $slot }}</section>
</dialog>

<script>
    const modal = document.querySelector('#modal');
    const closeBtnModal = document.querySelector('#modal-close-btn');

    closeBtnModal.addEventListener('click', function() {
        if (modal.open) {
            modal.open = false;
        } else {
            modal.open = true;
        }

        document.querySelector('#modal-backdrop').classList.replace('backdrop--show', 'backdrop--hide');
    });

    document.querySelector('#modal-backdrop').addEventListener('click', function() {
        if (modal.open) {
            modal.open = false;
        } else {
            modal.open = true;
        }

        document.querySelector('#modal-backdrop').classList.replace('backdrop--show', 'backdrop--hide');
    });
</script>
