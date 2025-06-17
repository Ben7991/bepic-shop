<x-layouts.dashboard>
    <x-slot name="title">My Tree</x-slot>

    <div class="flex gap-2 flex-col md:flex-row md:items-center md:justify-between mb-4 xl:mb-7">
        <h1 class="text-2xl font-bold">My Tree</h1>
        <a href="/dashboard/my-tree/create" class="hover:underline text-blue-700">
            Add Distributor <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="flex flex-wrap gap-3 md:gap-4 mb-4 xl:mb-7">
        <div class="bg-green-100 rounded-md flex justify-between basis-[48%] px-4 md:basis-1/4 py-3 xl:p-5 xl:basis-1/5">
            <div class="text-left">
                <p class="mb-1">Left Leg Points</p>
                <h4 class="font-semibold text-xl">{{ $leftLeg }}</h4>
            </div>
            <i class="bi bi-arrow-return-left text-3xl"></i>
        </div>
        <div class="bg-blue-100 rounded-md flex justify-between basis-[48%] px-4 py-3 md:basis-1/4 xl:p-5 xl:basis-1/5">
            <div class="text-left">
                <p class="mb-1">Right Leg Points</p>
                <h4 class="font-semibold text-xl">{{ $rightLeg }}</h4>
            </div>
            <i class="bi bi-arrow-return-right text-3xl"></i>
        </div>
        <div class="bg-red-100 rounded-md flex justify-between basis-[48%] px-4 py-3 md:basis-1/4 xl:p-5 xl:basis-1/5">
            <div class="text-left">
                <p class="mb-1">Total Matching Points</p>
                <h4 class="font-semibold text-xl">{{ $totalMatchingPoint }}</h4>
            </div>
            <i class="bi bi-diagram-2 text-3xl"></i>
        </div>
    </div>

    @if (session('message'))
        <div class="bg-green-100 text-green-700 p-3 rounded-md mb-4">
            {{ session()->get('message') }}
        </div>
    @endif

    @php
        function swap($distributors)
        {
            $newDistributors = ['LEFT', 'RIGHT'];

            foreach ($distributors as $distributor) {
                for ($j = 0; $j < 2; $j++) {
                    if ($newDistributors[$j] === $distributor->leg) {
                        $newDistributors[$j] = $distributor;
                    }
                }
            }

            return $newDistributors;
        }
    @endphp

    <div
        class="border rounded-full bg-white flex items-center justify-center text-[1.2em] mx-auto relative w-16 h-16 text-2xl">
        <i class="bi bi-person"></i>
        <div class="absolute w-[2px] h-5 bg-gray-500 left-1/2 -translate-x-1/2 top-16"></div>
    </div>
    @if (count($distributors) > 0)
        <div class="mx-auto w-[356px] flex mt-5 justify-between md:w-[500px] relative">
            <div class="w-[210px] md:w-[290px] absolute left-1/2 -translate-x-1/2 border border-gray-500"></div>
            @foreach (swap($distributors) as $distributor)
                @if ($distributor !== 'LEFT' && $distributor !== 'RIGHT')
                    @php $distUpline = $distributor->user->upline; @endphp
                    <div class="text-[1.2em] relative mt-5 cursor-pointer dist w-36 md:w-52">
                        <div class="absolute w-[2px] h-5 bg-gray-500 -top-5 left-1/2 -translate-x-1/2"></div>
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center border mx-auto"
                            onclick="showDownlineDetails({{ $distributor->id }})">
                            <i class="bi bi-person"></i>
                        </div>
                        @if ($distUpline !== null)
                            <div class="absolute w-[2px] h-6 bg-gray-500 top-10 left-1/2 -translate-x-1/2"></div>
                            <div class="w-full mt-6 mx-auto flex justify-between">
                                <div
                                    class="w-[88px] md:w-[154px] left-1/2 -translate-x-1/2 absolute border border-gray-500">
                                </div>
                                @foreach (swap($distUpline->distributors) as $dist2nd)
                                    @if ($dist2nd !== 'LEFT' && $dist2nd !== 'RIGHT')
                                        <div class="w-[54px] rounded-full mt-5 relative cursor-pointer dist"
                                            id="{{ $dist2nd->id }}">
                                            <div
                                                class="absolute w-[2px] h-5 bg-gray-500 -top-5 left-1/2 -translate-x-1/2">
                                            </div>
                                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center mx-auto border border-gray-500"
                                                onclick="showDownlineDetails({{ $dist2nd->id }})">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            @php $distUpline3rd = $dist2nd->user->upline; @endphp
                                            @if ($distUpline3rd !== null)
                                                <div
                                                    class="absolute w-[2px] h-5 bg-gray-500 top-10 left-1/2 -translate-x-1/2">
                                                </div>
                                                <div class="mt-5 flex justify-between">
                                                    <div
                                                        class="w-[54px] md:w-[54px] 2xl:w-[70px] left-1/2 -translate-x-1/2 absolute border border-gray-500">
                                                    </div>
                                                    @foreach (swap($distUpline3rd->distributors) as $dist3rd)
                                                        @if ($dist3rd !== 'LEFT' && $dist3rd !== 'RIGHT')
                                                            <div class="w-10 h-10 rounded-full mt-5 relative cursor-pointer dist {{ $dist3rd->leg === 'LEFT' ? 'justify-self-start -ms-[19px] 2xl:-ms-[27px]' : 'justify-self-end -me-[19px] 2xl:-me-[27px]' }}"
                                                                id="{{ $dist3rd->id }}">
                                                                <div
                                                                    class="absolute w-[2px] h-5 bg-gray-500 -top-5 left-1/2 -translate-x-1/2">
                                                                </div>
                                                                <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-white border border-gray-500 flex items-center justify-center mx-auto"
                                                                    onclick="showDownlineDetails({{ $dist3rd->id }})">
                                                                    <i class="bi bi-person"></i>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span class="inline-block"></span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="inline-block"></span>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <span class="inline-block"></span>
                @endif
            @endforeach
        </div>
    @endif

    <div class="fixed w-full h-full top-0 left-0 bg-black/50 z-10 hidden" id="modal-back-drop">
        <div class="fixed z-20 top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 bg-white w-[90%] p-4 rounded md:w-1/2 xl:w-[500px] xl:p-6 hidden"
            id="my-tree-modal">
            <div class="mb-4 xl:mb-7 flex items-center justify-between">
                <h1 class="text-2xl font-bold" id="dist-name">...</h1>
                <button class="text-2xl hover:text-red-700 cursor-pointer" onclick="closeModal()">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="space-y-4 md:space-y-0 md:flex gap-3 mb-4">
                <div class="border p-3 rounded flex-grow">
                    <p class="font-semibold">ID</p>
                    <h5 class="font-bold" id="dist-id">...</h5>
                </div>
                <div class="border p-3 rounded flex-grow">
                    <p class="font-semibold">Left Leg</p>
                    <h5 class="font-bold" id="dist-left-leg">...</h5>
                </div>
                <div class="border p-3 rounded flex-grow">
                    <p class="font-semibold">Right Leg</p>
                    <h5 class="font-bold" id="dist-right-leg">...</h5>
                </div>
            </div>
            <a href="#" class="text-blue-700 underline" id="dist-link">
                View my tree <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>


    @push('scripts')
        <script>
            const currentModal = document.querySelector('#my-tree-modal');
            const modalBackdrop = document.querySelector('#modal-back-drop');

            const distId = document.querySelector('#dist-id');
            const distName = document.querySelector('#dist-name');
            const distLeft = document.querySelector('#dist-left-leg');
            const distRight = document.querySelector('#dist-right-leg');
            const distLink = document.querySelector('#dist-link');


            async function showDownlineDetails(id) {
                const response = await fetch(`/dashboard/users/${id}`);
                const result = await response.json();

                showModal();

                distId.textContent = result.data.id;
                distLeft.textContent = result.data.left_leg;
                distRight.textContent = result.data.right_leg;
                distName.textContent = result.data.name;
                distLink.href = `/dashboard/my-tree/${result.data.id}`
            }

            function showModal() {
                currentModal.classList.remove('hidden');
                modalBackdrop.classList.remove('hidden');
            }

            function closeModal() {
                currentModal.classList.add('hidden');
                modalBackdrop.classList.add('hidden');

                distId.textContent = "...";
                distLeft.textContent = "...";
                distRight.textContent = "...";
                distLink.href = "#";
                distName.textContent = "...";
            }

            modalBackdrop.addEventListener('click', function(event) {
                if (event.target.id !== 'modal-back-drop') {
                    return;
                }

                closeModal();
            });
        </script>
    @endpush
</x-layouts.dashboard>
