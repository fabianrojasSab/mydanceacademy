<div class="grid lg:grid-cols-3 grid-cols-1 md:container md:mx-auto">
    <section class="lg:col-span-3 col-1 p-4">
        <div class="flex justify-end">
            <a href="{{ route('dashboard') }}" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                Volver
            </a>
        </div>
    </section>
    @hasanyrole('Administrador|SuperAdmin')
        <section class="lg:col-auto col-1 p-4">
            <livewire:alert />
            <form class="pt-6 px-9 pb-6 rounded-lg bg-white">
                <div class="mb-7">
                    <h1 class="text-2xl text-center font-semibold text-gray-900 dark:text-white">Inscripciones a clases</h1>
                </div>
                @csrf
                <div class="relative z-0 w-full mb-5 group">
                    <label for="estudiante_id" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent">Selecciona un estudiante</label>
                    <select id="estudiante_id" name="estudiante_id" wire:model="student_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option>...</option>
                        @foreach ($students as $student)
                            <tr>
                                <option value="{{$student->id}}">{{$student->name}}</option>
                            </tr>
                        @endforeach
                    </select>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <label for="clase_id" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent">Selecciona una clase</label>
                    <select id="clase_id" name="clase_id" wire:model="lesson_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option>...</option>
                        @foreach ($lessons as $lesson)
                            <tr>
                                <option value="{{$lesson->id}}">{{$lesson->name}}</option>
                            </tr>
                        @endforeach
                    </select>
                </div>
                <x-button class="ms-4" wire:click.prevent="{{ $inscriptionId ? 'update' : 'save' }}">
                    {{ $inscriptionId ? __('Actualizar') : __('Registrar') }}
                </x-button>
            </form>
        </section>
        
        <section class="lg:col-span-2 col-1 h-auto p-4">   
            <div class="h-full pt-6 px-2 rounded-lg bg-white">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                            <h3 class="font-semibold text-base text-blueGray-700">listado de inscripciones</h3>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-x-auto">
                    <table id="search-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    ESTUDIANTE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    CLASE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    FECHA DE INSCRIPCION
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    ACCIONES
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inscriptions as $inscription)
                                <tr>
                                    {{-- <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        @forelse ($inscription->users as $user)
                                        <span class="bg-indigo-100 text-indigo-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-indigo-900 dark:text-indigo-300">{{ $user->name }}</span>
                                        @empty
                                            <span>Rol no encontrado</span>
                                        @endforelse
                                    </th> --}}
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        {{ $inscription->student ? $inscription->student->name : 'Estudiante no encontrado' }}
                                    </th>
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        {{ $inscription->lesson ? $inscription->lesson->name : 'Clase no encontrada' }}
                                    </th>
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        {{$inscription->inscription_date}}
                                    </th>
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 ">
                                        <x-danger-button wire:click="delete({{ $inscription->id }})"  wire:confirm="Are you sure you want to delete this post?" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                            type="submit">Eliminar</x-danger-button>
                                        <button wire:click="edit({{ $inscription->id }})" 
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
    @endhasanyrole

    @role('Estudiante')
        <section class="col-span-6 h-3/4 p-4">   
            <div class="h-full pt-6 px-2 rounded-lg bg-white">
                <div class="">
                    <div class="rounded-t mb-0 px-4 py-3 border-0">
                        <div class="flex flex-wrap items-center">
                            <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                <h3 class="font-semibold text-base text-blueGray-700">listado de clases</h3>
                            </div>
                        </div>
                    </div>

                    <div class="relative overflow-x-auto">
                        <table id="search-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        CLASE
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        HORARIO
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        DURACION
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        PROFESOR
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        ACTIONS
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lessons as $lesson)
                                    <tr>
                                        <th wire:key="{{ $lesson->id }}" {{$this->clase_id = $lesson->id}} class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                            {{$lesson->id}}
                                        </th>
                                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                            {{ $lesson->nombre ? $lesson->nombre : 'Clase no encontrada' }}
                                        </th>
                                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                            {{$lesson->horario}}
                                        </th>
                                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                            {{$lesson->duracion}}
                                        </th>
                                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                            {{ $lesson->teacher ? $lesson->teacher->name : 'Profesor no encontrado' }}
                                        </th>
                                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 ">
                                            <button wire:click="save()" 
                                                class="bg-yellow-500 text-white active:bg-yellow-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                                                Inscribirse
                                            </button>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </section> 
    @endrole


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