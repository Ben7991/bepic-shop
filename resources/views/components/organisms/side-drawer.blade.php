@props(['title'])

<x-atoms.backdrop />
<aside
    class="bg-[var(--gray-1000)] drawer--hide lg:w-[300px!important] transition-[width] h-full
            fixed top-0 left-0 overflow-y-auto py-8 xl:py-10 lg:static lg:h-auto"
    id="side-drawer">
    <div class="mb-5 flex items-center justify-center xl:mb-10">
        <x-molecules.user-profile initials="MD" role="Admin" name="James Smith" />
    </div>
    <div class="flex flex-col gap-3 w-4/5 mx-auto">
        <a href="/dashboard"
            class="flex gap-2 items-center py-2 px-4 rounded-lg {{ $title == 'Dashboard' ? 'bg-[var(--sea-blue-100)] text-white' : 'hover:bg-[var(--gray-300)]' }}">
            <i class="bi bi-bar-chart text-xl"></i> Dashboard
        </a>
        <a href="/dashboard/membership-packages"
            class="flex gap-2 items-center py-2 px-4 rounded-lg {{ $title == 'Membership Packages' ? 'bg-[var(--sea-blue-100)] text-white' : 'hover:bg-[var(--gray-300)]' }}">
            <i class="bi bi-box text-xl"></i>
            Membership Packages
        </a>
        <a href="/dashboard/incentives"
            class="flex gap-2 items-center py-2 px-4 rounded-lg {{ $title == 'Incentives' ? 'bg-[var(--sea-blue-100)] text-white' : 'hover:bg-[var(--gray-300)]' }}">
            <i class="bi bi-gift text-xl"></i>
            Incentives
        </a>
        <a href="/dashboard/products"
            class="flex gap-2 items-center py-2 px-4 rounded-lg {{ $title == 'Products' ? 'bg-[var(--sea-blue-100)] text-white' : 'hover:bg-[var(--gray-300)]' }}">
            <i class="bi bi-capsule text-xl"></i>
            Products
        </a>
        <a href="/dashboard/order-history"
            class="flex gap-2 items-center py-2 px-4 rounded-lg {{ $title == 'Order History' ? 'bg-[var(--sea-blue-100)] text-white' : 'hover:bg-[var(--gray-300)]' }}">
            <i class="bi bi-clock-history text-xl"></i>
            Order History
        </a>
        <a href="/dashboard/top-sales-chart"
            class="flex gap-2 items-center py-2 px-4 rounded-lg {{ $title == 'Top Sales Chart' ? 'bg-[var(--sea-blue-100)] text-white' : 'hover:bg-[var(--gray-300)]' }}">
            <i class="bi bi-graph-up-arrow text-xl"></i>
            Top Sales Chart
        </a>
        <a href="/dashboard/wallet-transfer-history"
            class="flex gap-2 items-center py-2 px-4 rounded-lg {{ $title == 'Wallet Transfer History' ? 'bg-[var(--sea-blue-100)] text-white' : 'hover:bg-[var(--gray-300)]' }}">
            <i class="bi bi-wallet text-xl"></i>
            Wallet Transfer History
        </a>
        <a href="/dashboard/bonus-withdrawals"
            class="flex gap-2 items-center py-2 px-4 rounded-lg {{ $title == 'Bonus Withdrawals' ? 'bg-[var(--sea-blue-100)] text-white' : 'hover:bg-[var(--gray-300)]' }}">
            <i class="bi bi-cash-stack text-xl"></i>
            Bonus Withdrawals
        </a>
        <a href="/dashboard/distributors"
            class="flex gap-2 items-center py-2 px-4 rounded-lg {{ $title == 'Distributors' ? 'bg-[var(--sea-blue-100)] text-white' : 'hover:bg-[var(--gray-300)]' }}">
            <i class="bi bi-people text-xl"></i>
            Distributors
        </a>
        <a href="/dashboard/account-settings"
            class="flex gap-2 items-center py-2 px-4 rounded-lg {{ $title == 'Account Settings' ? 'bg-[var(--sea-blue-100)] text-white' : 'hover:bg-[var(--gray-300)]' }}">
            <i class="bi bi-gear text-xl"></i>
            Account Settings
        </a>
    </div>
</aside>
