<div class="lg:col-auto col-1 h-auto p-4">
    <section class="lg:col-span-2 col-1 h-auto p-4">   
        <div class="h-full pt-6 px-2 rounded-lg bg-white">
            <div class="rounded-t mb-0 px-4 py-3 border-0">
                <div class="flex flex-wrap items-center">
                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                        <h3 class="font-semibold text-base text-blueGray-700">{{$name}}</h3>
                    </div>
                </div>
            </div>
            <div class="relative overflow-x-auto">
                {{ $slot }}
            </div>
        </div>
    </section> 
</div>