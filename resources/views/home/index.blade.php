<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bepic Shopping</title>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <nav class="bg-white md:py-5 border-b border-b-gray-300">
        <x-atoms.content-wrapper class="flex justify-between items-center py-0 lg:py-0 xl:w-[1134px] lg:mx-auto">
            <x-molecules.app-logo />
            <a href="/login" class="text-blue-600 hover:underline">
                Login <i class="bi bi-arrow-right"></i>
            </a>
        </x-atoms.content-wrapper>
    </nav>

    <main>
        <section class="bg-gray-100 py-10 md:flex md:items-center relative">
            <x-atoms.content-wrapper class="md:flex md:items-center xl:w-[1134px] lg:mx-auto">
                <div class="w-full md:w-1/2 xl:w-1/2">
                    <h1 class="uppercase text-4xl font-bold mb-4">Let's grow</h1>
                    <p class="mb-4">
                        We can't wait to share with you our exciting income opportunity through Ecommerce with drop
                        shipping program which leads thousands of sellers to a successful business venture.
                    </p>
                    <p class="mb-4">
                        I'm sure you wouldn't want to miss this.
                        Come and join our growing BOS family today.
                    </p>
                    <a href="/login"
                        class="cursor-pointer inline-block py-3 bg-[var(--sea-blue-100)] text-white hover:bg-[var(--sea-blue-900)] active:bg-[var(--sea-blue-500)] rounded-lg px-4">
                        Join us now <i class="bi bi-arrow-right"></i>
                    </a>
                    <div class="flex mt-6">
                        <span class="inline-block border-r border-r-gray-300 pr-6">
                            <h3 class="text-2xl mb-1 font-semibold">2000+</h3>
                            <p>Total Distributors</p>
                        </span>
                        <span class="inline-block ps-6">
                            <h3 class="text-2xl mb-1 font-semibold">700+</h3>
                            <p>Total Award</p>
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2 xl:w-1/2 relative h-80 lg:h-[500px] xl:h-[500px] mt-5 md:mt-0">
                    <div
                        class="h-80 absolute left-1/2 -translate-x-1/2 slider-container overflow-hidden lg:h-[500px] xl:h-[500px]">
                        <div class="slider flex relative">
                            <div class="slider-item flex items-center">
                                <img src="{{ asset('assets/img/slider-1.jpeg') }}">
                            </div>
                            <div class="slider-item flex items-center">
                                <img src="{{ asset('assets/img/slider-2.jpeg') }}">
                            </div>
                            <div class="slider-item flex items-center">
                                <img src="{{ asset('assets/img/slider-3.jpeg') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </x-atoms.content-wrapper>
        </section>

        <section class="py-4 xl:py-10">
            <x-atoms.content-wrapper class="xl:w-[1134px] lg:mx-auto">
                <div class="mb-4 xl:mb-7">
                    <h1 class="text-2xl font-bold text-center mb-3">Our products and benefits</h1>
                </div>
                <div class="space-y-4 md:space-y-0 md:flex md:flex-wrap md:justify-center gap-6">
                    <div class="py-3 text-center rounded-md">
                        <h4 class="text-[1.2em] mb-4">Zum Zum</h4>
                        <img src="{{ asset('assets/img/bepic-7.jpeg') }}" class="w-80">
                    </div>
                    <div class="py-3 text-center rounded-md">
                        <h4 class="text-[1.2em] mb-4">Lokus Tea</h4>
                        <img src="{{ asset('assets/img/bepic-8.jpeg') }}" class="w-80">
                    </div>
                    <div class="py-3 text-center rounded-md">
                        <h4 class="text-[1.2em] mb-4">Mushroom Complex</h4>
                        <img src="{{ asset('assets/img/bepic-9.jpeg') }}" class="w-80">
                    </div>
                    <div class="py-3 text-center rounded-md">
                        <h4 class="text-[1.2em] mb-4">Esthom Cleaning Services</h4>
                        <img src="{{ asset('assets/img/bepic-10.jpeg') }}" class="w-80">
                    </div>
                    <div class="py-3 text-center rounded-md">
                        <h4 class="text-[1.2em] mb-4">V-edge</h4>
                        <img src="{{ asset('assets/img/bepic-11.jpeg') }}" class="w-80">
                    </div>
                </div>
            </x-atoms.content-wrapper>
        </section>
    </main>

    <footer class="py-4 xl:py-7 bg-gray-200">
        <x-atoms.content-wrapper class="text-center">
            <p>Bepic Shopping &copy; 2024 - {{ date('Y') }} | All rights reserved</p>
        </x-atoms.content-wrapper>
    </footer>
</body>

</html>
