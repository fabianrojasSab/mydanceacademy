<div class="grid lg:grid-cols-3 grid-cols-1 md:container md:mx-auto">
    <section class="lg:col-span-3 col-1 p-4">
        <div class="flex justify-end">
            <a href="{{ route('dashboard') }}" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                Volver
            </a>
        </div>
    </section>
    <section class="lg:col-auto col-1 p-4">
        <form class="pt-6 px-9 pb-6 rounded-lg bg-white">
            <div class="mb-7">
                <h1 class="text-2xl text-center font-semibold text-gray-900 dark:text-white">Registro de Estudiantes</h1>
            </div>
            @csrf
            <div class="relative z-0 w-full mb-5 group">
                <input type="name" wire:model="name" name="name" id="name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nombre Completo</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="date" wire:model="date_of_birth" name="fecha_nacimiento" id="fecha_nacimiento" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="fecha_nacimiento" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Fecha de nacimiento</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="number" wire:model="phone" name="telefono" id="telefono" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="telefono" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Telefono</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="email" wire:model="email" name="email" id="email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Correo electronico</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="password" wire:model="password" name="password" id="password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Contraseña</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="password" wire:model="password_confirmation" name="password_confirmation" id="password_confirmation" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="password_confirmation" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirmar Contraseña</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <label for="estado_id" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent">Seleccionar estado</label>
                <select id="estado_id" name="estado_id" wire:model="state_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option>...</option>
                    @foreach ($states as $state)
                        <tr>
                            <option value="{{$state->id}}">{{$state->name}}</option>
                        </tr>
                    @endforeach
                </select>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <label for="rol_id" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent">Seleccionar Rol</label>
                <select id="rol_id" name="rol_id" wire:model="rol_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option>...</option>
                    @foreach ($roles as $rol)
                        <tr>
                            <option value="{{$rol->name}}">{{$rol->name}}</option>
                        </tr>
                    @endforeach
                </select>
            </div>
            @role('SuperAdmin')
                <div class="relative z-0 w-full mb-5 group">
                    <label for="academia_id" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent">Selecciona una academia</label>
                    <select id="academia_id" name="academia_id" wire:model="academyId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option>...</option>
                        @foreach ($academies as $academy)
                            <tr>
                                <option value="{{$academy->id}}">{{$academy->name}}</option>
                            </tr>
                        @endforeach
                    </select>
                </div>
            @endrole
            <x-button class="ms-4" wire:click.prevent="{{ $studentId ? 'update' : 'save' }}">
                {{ $studentId ? __('Actualizar') : __('Registrar') }}
            </x-button>
        </form>
    </section>

    <section class="lg:col-span-2 col-1 h-auto p-4">   
        <div class="h-full pt-6 px-2 rounded-lg bg-white">
            <div class="rounded-t mb-0 px-4 py-3 border-0">
                <div class="flex flex-wrap items-center">
                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                        <h3 class="font-semibold text-base text-blueGray-700">Listado de alumnos</h3>
                    </div>
                </div>
            </div>

            <div class="relative overflow-x-auto">
                <table id="search-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                NOMBRE COMPLETO
                            </th>
                            <th scope="col" class="px-6 py-3">
                                CORREO ELECTRONICO
                            </th>
                            <th scope="col" class="px-6 py-3">
                                FECHA DE REGISTRO
                            </th>
                            <th scope="col" class="px-6 py-3">
                                TELEFONO
                            </th>
                            <th scope="col" class="px-6 py-3">
                                ACCIONES
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                    {{$student->name}}
                                </th>
                                <th  class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                    {{$student->email}}
                                </th>
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                    {{$student->created_at}}
                                </th>
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                    {{$student->phone}}
                                </th>
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 ">

                                    <x-danger-button wire:click="disable({{ $student->id }})"  wire:confirm="Esta seguro que desea eliminar?" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                        type="submit">Eliminar</x-danger-button>
                                    {{-- {{ route('categorias.save', $categoria->id) }} --}}
                                    <button wire:click="edit({{ $student->id }})" 
                                        class="bg-yellow-500 text-white active:bg-yellow-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                                        Editar
                                    </button>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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