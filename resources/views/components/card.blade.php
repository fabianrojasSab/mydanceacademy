<div class="max-w-sm mt-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <a href="#">
        <img class="rounded-t-lg" src="/docs/images/blog/image-1.jpg" alt="" />
    </a>
    <div class="p-5">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{$tittle}}</h5>
        </a>
        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{$description}}</p>
        <button  href="{{ route($ruta) }}" wire:navigate
        class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
        type="button">Ir</button>
        </a>
    </div>
</div>