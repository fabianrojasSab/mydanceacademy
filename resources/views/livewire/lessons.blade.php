<div class="grid lg:grid-cols-3 grid-cols-1 md:container md:mx-auto">
    <section class="lg:col-span-3 col-1 p-4">
        <div class="flex justify-end">
            <a href="{{ route('dashboard') }}" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                Volver
            </a>
        </div>
    </section>

    @hasanyrole('Administrador|SuperAdmin')
        <!-- Contenido para administradores -->
        <section class="lg:col-auto col-1 p-4">
            <form class="pt-6 px-9 pb-6 rounded-lg bg-white">
                <div class="mb-7">
                    <h1 class="text-2xl text-center font-semibold text-gray-900 dark:text-white">Registro de clases</h1>
                </div>
                @csrf
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" wire:model="name" name="nombre" id="nombre" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="nombre" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nombre</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" wire:model="description" name="descripcion" id="descripcion" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="descripcion" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Descripcion</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="number" wire:model="capacity" name="capacidad" id="capacidad" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="capacidad" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Capacidad</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="duracion" wire:model="duration" name="duracion" id="duracion" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="duracion" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Duracion</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="date" wire:model="start_date" name="fecha_inicio" id="fecha_inicio" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="fecha_inicio" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Fecha de Inicio</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="date" wire:model="end_date" name="fecha_fin" id="fecha_fin" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="fecha_fin" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Fecha de Fin</label>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="hora_inicio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hora inicio:</label>
                        <input type="time" id="hora_inicio" wire:model="start_time" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" min="09:00" max="18:00" value="00:00" required />
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="hora_fin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hora fin:</label>
                        <input type="time" id="hora_fin" wire:model="end_time" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" min="09:00" max="18:00" value="00:00" required />
                    </div>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    @foreach ($selectedDays as $index => $day)
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="day_{{ $index }}" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent">Selecciona un día</label>
                            <select id="day_{{ $index }}" name="day[]" wire:model="selectedDays.{{ $index }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option>...</option>
                                <option value="1">Lunes</option>
                                <option value="2">Martes</option>
                                <option value="3">Miércoles</option>
                                <option value="4">Jueves</option>
                                <option value="5">Viernes</option>
                                <option value="6">Sábado</option>
                                <option value="7">Domingo</option>
                            </select>
                            <button type="button" wire:click="removeDay({{ $index }})" class="mt-2 text-red-600 hover:text-white border border-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center">
                                Eliminar
                            </button>
                        </div>
                    @endforeach
                </div>
                <!-- Botones para agregar más campos -->
                <div class="relative z-0 w-full mb-5 group">
                    <button type="button" wire:click="addDay" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">
                        Agregar otro día
                    </button>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <label for="user_id" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent">Selecciona un profesor</label>
                    <select id="user_id" name="user_id" wire:model="teacherId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option>...</option>
                        @foreach ($teachers as $teacher)
                            <tr>
                                <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                            </tr>
                        @endforeach
                    </select>
                </div>
                <x-button class="ms-4" wire:click.prevent="{{ $lessonId ? 'update' : 'save' }}">
                    {{ $lessonId ? __('Update') : __('Register') }}
                </x-button>
            </form>
        </section>
        
        <section class="lg:col-span-2 col-1 h-auto p-4">   
            <div class="h-full pt-6 px-2 rounded-lg bg-white">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                            <h3 class="font-semibold text-base text-blueGray-700">Listado de clases programadas</h3>
                        </div>
                    </div>
                </div>
    
                <div class="relative overflow-x-auto">
                    <table id="search-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    NOMBRE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    DESCRIPCION
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    DURACION
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    PROFESOR
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    HORARIO
                                </th>
                                @hasanyrole('SuperAdmin')
                                    <th scope="col" class="px-6 py-3">
                                        ACADEMIA
                                    </th>
                                @endrole
                                <th scope="col" class="px-6 py-3">
                                    ACCIONES
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($lessons)
                                @foreach ($lessons as $lesson)
                                    <tr>
                                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                            {{$lesson->name}}
                                        </th>
                                        <th  class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                            {{$lesson->description}}
                                        </th>
                                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                            {{$lesson->duration}} H
                                        </th>
                                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                            @if($lesson->teachers)
                                            @foreach ($lesson->teachers as $teacher)
                                                <li>{{ $teacher->name }}</li>
                                            @endforeach
                                            @else
                                                No hay profesores asignados
                                            @endif
                                        </th>
                                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                            {{$lesson->schedule}}
                                        </th>
                                        @hasanyrole('SuperAdmin')
                                            <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                                {{$lesson->academy->name}}
                                            </th>
                                        @endrole
                                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 ">
                                            @hasanyrole('SuperAdmin')
                                                <x-danger-button wire:click="delete({{ $lesson->id }})"  wire:confirm="Esta seguro que desea eliminar?" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                                    type="submit">Eliminar</x-danger-button>
                                                <x-danger-button wire:click="disable({{ $lesson->id }})"  wire:confirm="Esta seguro que desea eliminar?" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                                    type="submit">Inactivar</x-danger-button>
                                            @elsehasanyrole('Administrador')
                                                <x-danger-button wire:click="disable({{ $lesson->id }})"  wire:confirm="Esta seguro que desea eliminar?" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                                        type="submit">Inactivar</x-danger-button>
                                            @endrole
                                            <button wire:click="edit({{ $lesson->id }})" 
                                                class="bg-yellow-500 text-white active:bg-yellow-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                                                Editar
                                            </button>
                                        </th>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 " colspan="7">No hay clases registradas</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section> 
    @endhasanyrole

    @hasanyrole('Profesor|Estudiante')
        <!-- Contenido para profesores -->
        <section class="col-span-3 h-auto p-4">   
            <div class="h-full pt-6 px-2 rounded-lg bg-white">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                            <h3 class="font-semibold text-base text-blueGray-700">Listado de clases programadas</h3>
                        </div>
                    </div>
                </div>
    
                <div class="relative overflow-x-auto">
                    <table id="search-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    NOMBRE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    DESCRIPCION
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    CAPACIDAD
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    DURACION
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    HORARIO   
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    PROFESOR
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    ACCIONES
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lessons as $lesson)
                                <tr>
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        {{$lesson->name}}
                                    </th>
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        {{$lesson->description}}
                                    </th>
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        {{$lesson->capacity}}
                                    </th>
                                    <th  class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        {{$lesson->duration}}
                                    </th>
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        {{$lesson->horario}}
                                    </th>
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        {{$lesson->nombre}}
                                    </th>
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        {{ $lesson->teacher ? $lesson->teacher->name : 'Profesor no encontrado' }}
                                    </th>
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 ">
                                        <x-danger-button wire:click="delete({{ $lesson->id }})"  wire:confirm="Esta seguro que desea eliminar?" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                            type="submit">Eliminar</x-danger-button>
                                        <button wire:click="edit({{ $lesson->id }})" 
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