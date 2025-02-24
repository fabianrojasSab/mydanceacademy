<div class="grid lg:grid-cols-3 grid-cols-1 md:container md:mx-auto">
    <section class="lg:col-span-3 col-1 p-4">
        <div class="flex justify-end">
            <a href="{{ route('dashboard') }}" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                Volver
            </a>
        </div>
    </section>
    <section class="lg:col-auto col-1 p-4">
        @if (session()->has('message'))
            <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">
                    {{ session('message') }}
                </div>
                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                </button>
            </div>
        @endif
        <form class="pt-6 px-9 pb-6 rounded-lg bg-white">
            <div class="mb-7">
                <h1 class="text-2xl text-center font-semibold text-gray-900 dark:text-white">Registro de Permisos</h1>
            </div>
            @csrf
            <div class="mb-6">
                <label for="name" class="block text-sm text-gray-800 dark:text-gray-200">Nombre</label>
                <input type="text" wire:model="name" id="name" class="w-full px-4 py-2 mt-2 text-base text-gray-700 placeholder-gray-400 bg-white rounded-lg border border-gray-300 appearance-none focus:outline-none focus:border-blue-500" placeholder="Nombre del permiso">
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-6">
                <label for="guard_name" class="block text-sm text-gray-800 dark:text-gray-200">Autenticación</label>
                <input type="text" wire:model="guard_name" id="guard_name" class="w-full px-4 py-2 mt-2 text-base text-gray-700 placeholder-gray-400 bg-white rounded-lg border border-gray-300 appearance-none focus:outline-none focus:border-blue-500" placeholder="Autenticación">
                @error('guard_name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            
            <x-button class="ms-4" wire:click.prevent="{{ $permissionId ? 'update' : 'save' }}">
                {{ $permissionId ? __('Actualizar') : __('Registrar') }}
            </x-button>
        </form>
    </section>

    <section class="lg:col-span-2 col-1 h-auto p-4">   
        <div class="h-full pt-6 px-2 rounded-lg bg-white">
            <div class="rounded-t mb-0 px-4 py-3 border-0">
                <div class="flex flex-wrap items-center">
                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                        <h3 class="font-semibold text-base text-blueGray-700">Listado de usuarios</h3>
                    </div>
                </div>
            </div>

            <div class="relative overflow-x-auto">
                <x-table :headers="['ID', 'NOMBRE', 'AUTENTICACION','ACCIONES']">
                    @foreach ($permissions as $permission)
                        <tr>
                            <td class="px-6 py-4">{{ $permission->id }}</td>
                            <td class="px-6 py-4">{{ $permission->name }}</td>
                            <td class="px-6 py-4">{{ $permission->guard_name }}</td>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                <button wire:click="edit({{ $permission->id }})" class="bg-blue-500 text-white active:bg-blue-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                                    Editar
                                </button>
                                <button wire:click="destroy({{ $permission->id }})" class="bg-red-500 text-white active:bg-red-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </div>
        </div>
    </section>

    <!-- Modal de Carga -->
    <div x-data="{ loading: false }" x-show="loading" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75">
        <div class="bg-white p-5 rounded-lg shadow-lg text-center">
            <svg class="animate-spin h-5 w-5 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 01-8 8 8 8 0 01-8-8z"></path>
            </svg>
            <p class="mt-4 text-gray-700">Cargando...</p>
        </div>
    </div>
</div>
