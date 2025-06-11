<header class="border-b border-b-[var(--gray-800)] w-full">
    <x-atoms.content-wrapper class="flex items-center justify-between">
        <x-molecules.app-logo />
        <div class="flex gap-3 items-center">
            <button class="lg:hidden block" title="Show drawer menu" id="mobile-menu">
                <i class="bi bi-list text-2xl"></i>
            </button>
            <button class="cursor-pointer hover:text-[var(--sea-blue-100)]" title="Logout">
                <i class="bi bi-box-arrow-right text-2xl"></i>
            </button>
        </div>
    </x-atoms.content-wrapper>
</header>

<script>
    const backDrop = document.querySelector('#backdrop');
    const sideDrawer = document.querySelector('#side-drawer');
    const mobileMenu = document.querySelector('#mobile-menu');

    mobileMenu.addEventListener('click', function() {
        if (sideDrawer.classList.contains('drawer--hide')) {
            sideDrawer.classList.replace('drawer--hide', 'drawer--show');
        } else {
            sideDrawer.classList.replace('drawer--show', 'drawer--hide');
        }

        if (backDrop.classList.contains('backdrop--hide')) {
            backDrop.classList.replace('backdrop--hide', 'backdrop--show');
        } else {
            backDrop.classList.replace('backdrop--show', 'backdrop--hide');
        }
    });

    backDrop.addEventListener('click', function() {
        if (sideDrawer.classList.contains('drawer--show')) {
            sideDrawer.classList.replace('drawer--show', 'drawer--hide');
        } else {
            sideDrawer.classList.replace('drawer--hide', 'drawer--show');
        }

        if (backDrop.classList.contains('backdrop--show')) {
            backDrop.classList.replace('backdrop--show', 'backdrop--hide');
        } else {
            backDrop.classList.replace('backdrop--hide', 'backdrop--show');
        }
    });
</script>
