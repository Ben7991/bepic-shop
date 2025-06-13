<header class="border-b border-b-[var(--gray-800)] w-full">
    <x-atoms.content-wrapper class="flex items-center justify-between">
        <x-molecules.app-logo />
        <div class="flex gap-3 items-center">
            <button class="lg:hidden block" title="Show drawer menu" id="mobile-menu">
                <i class="bi bi-list text-2xl"></i>
            </button>
            <button class="cursor-pointer hover:text-[var(--sea-blue-100)]" title="Logout" id="btn-logout">
                <i class="bi bi-box-arrow-right text-2xl"></i>
            </button>
        </div>
    </x-atoms.content-wrapper>
</header>
<x-organisms.modal title="Logout">
    <p class="mb-4 text-[var(--black-300)]">
        Sorry, your logged-in session just expired. Please login again for a new
        session, or you can cancel to return back to the home page
    </p>
    <form action="/logout" method="POST">
        @csrf
        <button type="submit"
            class="cursor-pointer py-3 bg-[var(--sea-blue-100)] text-white hover:bg-[var(--sea-blue-900)] active:bg-[var(--sea-blue-500)] rounded-lg w-[150px]">
            Logout
        </button>
    </form>
</x-organisms.modal>

<script>
    const backDrop = document.querySelector('#backdrop');
    const sideDrawer = document.querySelector('#side-drawer');
    const mobileMenu = document.querySelector('#mobile-menu');
    const btnLogout = document.querySelector('#btn-logout');

    btnLogout.addEventListener('click', function() {
        document.querySelector('#modal').open = true;
        document.querySelector('#modal-backdrop').classList.replace('backdrop--hide', 'backdrop--show')
    });

    mobileMenu.addEventListener('click', function() {
        sideDrawer.classList.replace('drawer--hide', 'drawer--show');
        backDrop.classList.replace('backdrop--hide', 'backdrop--show');
    });

    backDrop.addEventListener('click', function() {
        sideDrawer.classList.replace('drawer--show', 'drawer--hide');
        backDrop.classList.replace('backdrop--show', 'backdrop--hide');
    });
</script>
