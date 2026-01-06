<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Energy888</title>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}">
    @vite(['resources/css/app.css'])
</head>

<body>
    <nav class="bg-white border-b border-b-gray-300">
        <x-atoms.backdrop />
        <x-atoms.content-wrapper class="flex justify-between items-center py-0 lg:py-0 xl:w-[1134px] lg:mx-auto lg:gap-5">
            <x-molecules.app-logo />
            <a href="/login" class="text-blue-600 hover:underline">
                Login <i class="bi bi-arrow-right"></i>
            </a>
        </x-atoms.content-wrapper>
    </nav>

    <main>
        <article id="home" class="text-center py-5 md:py-12">
            <x-atoms.content-wrapper class="xl:w-[1134px] lg:mx-auto text-center">
                <div class="w-full md:w-2/3 lg:w-3/5 inline-block">
                    <h1 class="text-3xl mb-3">Your Ambition. Our Community. Shared Success.</h1>
                    <p>
                        You are in business for yourself, but never by yourself. Join a thriving global network of entrepreneurs dedicated to lifting each other up. We offer the tools, training, and ecosystem to turn your drive into sustainable growth.
                    </p>
                </div>
            </x-atoms.content-wrapper>
        </article>
        <article class="pb-5">
            <x-atoms.content-wrapper class="xl:w-[1134px] lg:mx-auto flex flex-wrap gap-5 md:gap-0 items-center justify-evenly">
                <div class="flex items-center gap-2">
                    <img src="{{ asset("assets/img/people.svg") }}" alt="Distributors" class="w-14" />
                    <div class="space-y-1">
                        <h4 class="text-xl">Distributors</h4>
                        <p>1,570,000&nbsp;&nbsp;<i class="bi bi-graph-up-arrow"></i></p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <img src="{{ asset("assets/img/product.svg") }}" alt="Product" class="w-14" />
                    <div class="space-y-1">
                        <h4 class="text-xl">Products</h4>
                        <p>300</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <img src="{{ asset("assets/img/location.svg") }}" alt="Headquaters" class="w-14" />
                    <div class="space-y-1">
                        <h4 class="text-xl">Headquarters</h4>
                        <p>Serbia, India & China</p>
                    </div>
                </div>
            </x-atoms.content-wrapper>
        </article>
        <article id="about-us" class="py-5 md:py-12">
            <x-atoms.content-wrapper class="space-y-5 md:flex md:justify-between md:items-center xl:w-[1134px] lg:mx-auto">
                <div class="basis-full md:basis-5/12">
                    <h3 class="text-2xl mb-4">About Us</h3>
                    <p class="mb-2">
                        Energy888 is a Global Network Marketing Company operating direct sales operations in 17 countries worldwide, including Ghana, as of 2025.
                    </p>
                    <p class="mb-2">
                        Look Mee Group operated in the Americas, Asia, and Europe, finally Africa established this business on September 15th, 2014
                    </p>
                    <p>
                        
                    </p>
                </div>
                <div class="basis-full md:basis-6/12">
                    <img src="{{ asset('assets/img/energy-1.jpg') }}" alt="About us image" class="w-full rounded-md" />
                </div>
            </x-atoms.content-wrapper>
        </article>
        <article id="products" class="py-5 md:py-12">
            <x-atoms.content-wrapper class="xl:w-[1134px] lg:mx-auto">
                <div class="mx-auto w-2/3 md:w-2/5 lg:w-2/6 text-center mb-5">
                    <h3 class="text-2xl mb-4">Product</h3>
                    <p>Health, Wellness, Skincare, or Fitness products.</p>
                </div>
                <div class="flex flex-col gap-3 md:flex-row md:flex-wrap md:justify-between md:gap-5">
                    <div class="basis-full md:basis-3/12 h-[300px] overflow-hidden">
                        <img src="{{ asset('assets/img/product-1.jpeg') }}" alt="Product image" class="w-full h-full object-cover"/>
                    </div>
                    <div class="basis-full md:basis-3/12 h-[300px] overflow-hidden">
                        <img src="{{ asset('assets/img/product-2.jpeg') }}" alt="Product image" class="w-full h-full object-cover"/>
                    </div>
                    <div class="basis-full md:basis-3/12 h-[300px] overflow-hidden">
                        <img src="{{ asset('assets/img/product-3.jpeg') }}" alt="Product image" class="w-full h-full object-cover"/>
                    </div>
                    <div class="basis-full md:basis-3/12 h-[300px] overflow-hidden">
                        <img src="{{ asset('assets/img/product-4.jpeg') }}" alt="Product image" class="w-full h-full object-cover"/>
                    </div>
                    <div class="basis-full md:basis-3/12 h-[300px] overflow-hidden">
                        <img src="{{ asset('assets/img/product-5.jpeg') }}" alt="Product image" class="w-full h-full object-cover"/>
                    </div>
                    <div class="basis-full md:basis-3/12 h-[300px] overflow-hidden">
                        <img src="{{ asset('assets/img/product-6.jpeg') }}" alt="Product image" class="w-full h-full object-cover"/>
                    </div>
                    <div class="basis-full md:basis-3/12 h-[300px] overflow-hidden">
                        <img src="{{ asset('assets/img/product-7.jpeg') }}" alt="Product image" class="w-full h-full object-cover"/>
                    </div>
                    <div class="basis-full md:basis-3/12 h-[300px] overflow-hidden">
                        <img src="{{ asset('assets/img/product-8.jpeg') }}" alt="Product image" class="w-full h-full object-cover"/>
                    </div>
                    <div class="basis-full md:basis-3/12 h-[300px] overflow-hidden">
                        <img src="{{ asset('assets/img/product-9.jpeg') }}" alt="Product image" class="w-full h-full object-cover"/>
                    </div>
                </div>
            </x-atoms.content-wrapper>
        </article>
    </main>
    
    <footer class="py-3 bg-gray-200">
        <x-atoms.content-wrapper class="text-center">
            <p>Energy888 &copy; 2024 - {{ date('Y') }} | All rights reserved</p>
        </x-atoms.content-wrapper>
    </footer>
</body>

</html>
