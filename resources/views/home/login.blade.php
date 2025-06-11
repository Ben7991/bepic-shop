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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <main class="w-full h-screen flex items-center justify-center bg-gray-600">
        <section class="bg-white rounded-lg p-4 lg:p-6 xl:p-8 basis-[92%] md:basis-[471px] shadow-md space-y-4">
            <x-molecules.app-logo />
            <h4 class="text-2xl font-medium">Login</h4>
            <p>Please enter your login details below to access your account.</p>
            <form action="/login" method="post">
                @csrf

                <div class="mb-4">
                    <label for="username" class="inline-block mb-1">Username</label>
                    <input type="text" name="username" id="username"
                        class="flex items-center px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)]">
                    @error('username')
                        <p class="text-[var(--error-100)]">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="password" class="inline-block mb-1">Password</label>
                    <input type="text" name="password" id="password"
                        class="flex items-center px-4 border rounded-lg gap-2 form-control w-full py-2 outline-none border-[var(--gray-300)]">
                    @error('password')
                        <p class="text-[var(--error-100)]">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col">
                    <button type="submit"
                        class="cursor-pointer py-3 bg-[var(--sea-blue-100)] text-white hover:bg-[var(--sea-blue-900)] active:bg-[var(--sea-blue-500)] rounded-lg">
                        Sign-in
                    </button>
                </div>
            </form>
            <p class="text-center">
                Go back to the <a href="/" class="text-[var(--sea-blue-100)] hover:underline">home page</a>
            </p>
        </section>
    </main>
</body>

</html>
