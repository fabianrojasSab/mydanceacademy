<div class="max-w-sm mt-5 bg-white shadow-lg p-6 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 hover:shadow-xl transition rounded-xl cursor-pointer">
    <div class="grid lg:grid-cols-3 grid-cols-1 md:container md:mx-auto">
        <div class="lg:col-span-2 col-1 h-auto ">
            <a href="#">
                <img class="rounded-t-lg" src="/docs/images/blog/image-1.jpg" alt="" />
            </a>
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{$tittle}}</h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{$description}}</p>
        </div>
        <div class="lg:col-auto col-1 flex items-center justify-center">
            <button  href="{{ route($ruta) }}" wire:navigate
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-full transition"
            type="button">Ir</button>
        </div>
    </div>
</div>